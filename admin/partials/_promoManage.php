<?php
require_once('../../includes/_dbconnect.php');

// =================== CREATE PROMO CODE ===================
if (isset($_POST['create_promo'])) {
    $promo_code = strtoupper($_POST['promo_code']);
    $discount_type = $_POST['discount_type'];
    $discount_value = $_POST['discount_value'];
    $expiry_date = $_POST['expiry_date'];
    $usage_limit = intval($_POST['usage_limit']);
    $is_active = intval($_POST['is_active']);

    $stmt = $conn->prepare("INSERT INTO tbl_promo_codes (promo_code, discount_type, discount_value, expiry_date, usage_limit, is_active) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdssi", $promo_code, $discount_type, $discount_value, $expiry_date, $usage_limit, $is_active);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Promo code created successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not create promo code. It might already exist.";
        $_SESSION['msg_type'] = 'danger';
    }
    $stmt->close();
    header("Location: ../promoManage.php");
    exit();
}

// =================== DELETE PROMO CODE ===================
if (isset($_POST['delete_promo'])) {
    $promo_id = intval($_POST['promo_id']);
    
    $stmt = $conn->prepare("DELETE FROM tbl_promo_codes WHERE id = ?");
    $stmt->bind_param("i", $promo_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Promo code deleted successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not delete promo code.";
        $_SESSION['msg_type'] = 'danger';
    }
    $stmt->close();
    header("Location: ../promoManage.php");
    exit();
}
?>