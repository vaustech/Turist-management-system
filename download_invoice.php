<?php
// প্রয়োজনীয় ফাইল যুক্ত করা হচ্ছে
require_once('includes/_dbconnect.php');

// সেশন স্টার্ট করতে ভুলবে না
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ব্যবহারকারী লগইন করা না থাকলে তাকে ফেরত পাঠানো হবে
if (!isset($_SESSION['user_loggedin']) || $_SESSION['user_loggedin'] !== true) {
    die("Authentication required. Please login first.");
}

$user_id = $_SESSION['user_id'];
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

if ($booking_id === 0) {
    die("Invalid request: No booking ID provided.");
}

// নিরাপত্তা চেক: ব্যবহারকারী শুধুমাত্র তার নিজের ইনভয়েস দেখতে পারবে
$sql = "SELECT 
            b.*, 
            u.name as user_name, 
            u.emailid as user_email, 
            p.package_name, 
            p.package_price 
        FROM tbl_booking b
        JOIN tbl_userregistration u ON b.user_id = u.id
        JOIN tbl_tourpackage p ON b.package_id = p.id
        WHERE b.id = ? AND b.user_id = ? AND b.status = 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$details = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$details) {
    die("Invoice not found or you do not have permission to view it.");
}

// ইনভয়েসের জন্য ডেটা প্রস্তুত করা হচ্ছে
$subtotal = $details['package_price'] * $details['num_people'];
$total_amount = $subtotal - $details['discount_amount'];
$balance_due = $total_amount - $details['paid_amount'];

// HTML টেমপ্লেট লোড
$invoice_html = file_get_contents('invoice_template.php');

// টেমপ্লেটে আসল ডেটা বসানো হচ্ছে
$replacements = [
    '{{customer_name}}'   => $details['user_name'],
    '{{customer_email}}'  => $details['user_email'],
    '{{invoice_id}}'      => $details['id'],
    '{{booking_date}}'    => date('d M, Y', strtotime($details['created_at'])),
    '{{payment_method}}'  => htmlspecialchars($details['payment_method']),
    '{{package_name}}'    => htmlspecialchars($details['package_name']),
    '{{trip_date}}'       => date('d M, Y', strtotime($details['from_date'])),
    '{{num_people}}'      => $details['num_people'],
    '{{transaction_id}}'  => htmlspecialchars($details['transaction_id']),
    '{{package_price}}'   => number_format($details['package_price']),
    '{{subtotal}}'        => number_format($subtotal),
    '{{discount_amount}}' => number_format($details['discount_amount']),
    '{{total_amount}}'    => number_format($total_amount),
    '{{paid_amount}}'     => number_format($details['paid_amount']),
    '{{balance_due}}'     => number_format($balance_due),
];

$invoice_html = strtr($invoice_html, $replacements);

// ব্রাউজারে সরাসরি HTML রেন্ডার করা হবে
echo $invoice_html;
?>
