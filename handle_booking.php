<?php
require_once('includes/_dbconnect.php');

if (!isset($_SESSION['user_loggedin']) || $_SESSION['user_loggedin'] !== true || !isset($_POST['submit_booking'])) {
    header("Location: login.php");
    exit;
}

// ফর্ম থেকে সব তথ্য সংগ্রহ করা হচ্ছে
$user_id = intval($_POST['user_id']);
$package_id = intval($_POST['package_id']);
$avail_id = intval($_POST['avail_id']);
$num_people = intval($_POST['num_people']);
$promo_code_input = isset($_POST['promo_code']) ? strtoupper(trim($_POST['promo_code'])) : '';
$comment = $_POST['comment'];
$payment_method = $_POST['payment_method'];
$paid_amount = floatval($_POST['paid_amount']);
$transaction_id = $_POST['transaction_id'];

// ডাটাবেস ট্রানজ্যাকশন শুরু
mysqli_begin_transaction($conn);

try {
    // ১. প্যাকেজ এবং অ্যাভেইলেবিলিটির বিস্তারিত তথ্য আনা হচ্ছে
    $stmt_avail = $conn->prepare("SELECT pa.trip_date, pa.total_seats, pa.booked_seats, pkg.package_price 
                                  FROM tbl_package_availability pa
                                  JOIN tbl_tourpackage pkg ON pa.package_id = pkg.id
                                  WHERE pa.id = ? FOR UPDATE");
    $stmt_avail->bind_param("i", $avail_id);
    $stmt_avail->execute();
    $availability = $stmt_avail->get_result()->fetch_assoc();
    $stmt_avail->close();

    if (!$availability) throw new Exception("Availability not found.");

    // ২. সিট খালি আছে কিনা তা চেক করা হচ্ছে
    $available_seats = $availability['total_seats'] - $availability['booked_seats'];
    if ($available_seats < $num_people) throw new Exception("Sorry, only {$available_seats} seats are available.");

    // ৩. প্রোমো কোড যাচাই এবং ডিসকাউন্ট হিসাব করা হচ্ছে
    $discount_amount = 0;
    $promo_code_id = null;
    if (!empty($promo_code_input)) {
        $today = date('Y-m-d');
        $stmt_promo = $conn->prepare("SELECT * FROM tbl_promo_codes WHERE promo_code = ? AND is_active = 1 AND expiry_date >= ? AND usage_count < usage_limit FOR UPDATE");
        $stmt_promo->bind_param("ss", $promo_code_input, $today);
        $stmt_promo->execute();
        $promo_details = $stmt_promo->get_result()->fetch_assoc();
        $stmt_promo->close();

        if ($promo_details) {
            $subtotal = $availability['package_price'] * $num_people;
            if ($promo_details['discount_type'] == 'percentage') {
                $discount_amount = ($subtotal * $promo_details['discount_value']) / 100;
            } else {
                $discount_amount = $promo_details['discount_value'];
            }
            $promo_code_id = $promo_details['id'];
        } else {
            throw new Exception("The promo code you used is invalid or expired. Please try again.");
        }
    }

    // ৪. tbl_booking টেবিলে নতুন বুকিং যোগ করা হচ্ছে
    $trip_date = $availability['trip_date'];
    $sql_insert = "INSERT INTO tbl_booking (user_id, package_id, from_date, to_date, comment, num_people, promo_code_used, discount_amount, payment_method, paid_amount, transaction_id, status) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iisssisdsds", $user_id, $package_id, $trip_date, $trip_date, $comment, $num_people, $promo_code_input, $discount_amount, $payment_method, $paid_amount, $transaction_id);
    if (!$stmt_insert->execute()) throw new Exception("Error creating booking record.");
    $stmt_insert->close();

    // ৫. tbl_package_availability টেবিলে booked_seats সংখ্যা আপডেট করা হচ্ছে
    $stmt_update_seats = $conn->prepare("UPDATE tbl_package_availability SET booked_seats = booked_seats + ? WHERE id = ?");
    $stmt_update_seats->bind_param("ii", $num_people, $avail_id);
    if (!$stmt_update_seats->execute()) throw new Exception("Error updating seat count.");
    $stmt_update_seats->close();

    // ৬. tbl_promo_codes টেবিলে usage_count আপডেট করা হচ্ছে (যদি প্রোমো কোড ব্যবহার করা হয়)
    if ($promo_code_id) {
        $stmt_update_promo = $conn->prepare("UPDATE tbl_promo_codes SET usage_count = usage_count + 1 WHERE id = ?");
        $stmt_update_promo->bind_param("i", $promo_code_id);
        if (!$stmt_update_promo->execute()) throw new Exception("Error updating promo code usage.");
        $stmt_update_promo->close();
    }

    // ৭. সবকিছু ঠিক থাকলে ট্রানজ্যাকশন কমিট করা হচ্ছে
    mysqli_commit($conn);
    header("Location: thank-you.php?booking=success");
    exit();

} catch (Exception $e) {
    // কোনো ভুল হলে ট্রানজ্যাকশন রোলব্যাক করা হচ্ছে
    mysqli_rollback($conn);
    $_SESSION['booking_error'] = $e->getMessage();
    header("Location: booking.php?pkgid={$package_id}&availid={$avail_id}");
    exit();
}
?>