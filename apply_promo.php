<?php
require_once('includes/_dbconnect.php');

// রেসপন্স পাঠানোর জন্য হেডার সেট করা হচ্ছে
header('Content-Type: application/json');

// রেসপন্সের জন্য একটি অ্যারে তৈরি করা হচ্ছে
$response = [
    'status' => 'error',
    'message' => 'An unknown error occurred.',
    'discount' => 0
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $promo_code = strtoupper(trim($_POST['promo_code']));
    $subtotal = floatval($_POST['subtotal']);
    
    if (empty($promo_code)) {
        $response['message'] = 'Please enter a promo code.';
        echo json_encode($response);
        exit();
    }

    $today = date('Y-m-d');

    // ডাটাবেস থেকে প্রোমো কোডটি যাচাই করা হচ্ছে
    $stmt = $conn->prepare("SELECT * FROM tbl_promo_codes WHERE promo_code = ? AND is_active = 1 AND expiry_date >= ? AND usage_count < usage_limit");
    $stmt->bind_param("ss", $promo_code, $today);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $code_details = $result->fetch_assoc();
        $discount_value = $code_details['discount_value'];
        $discount_type = $code_details['discount_type'];
        $discount_amount = 0;

        // ডিসকাউন্টের পরিমাণ হিসাব করা হচ্ছে
        if ($discount_type == 'percentage') {
            $discount_amount = ($subtotal * $discount_value) / 100;
        } else { // fixed
            $discount_amount = $discount_value;
        }

        $response['status'] = 'success';
        $response['message'] = 'Promo code applied successfully!';
        $response['discount'] = $discount_amount;
        
    } else {
        $response['message'] = 'Invalid or expired promo code.';
    }
    $stmt->close();
}

echo json_encode($response);
?>