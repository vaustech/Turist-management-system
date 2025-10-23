<?php
require_once('includes/_dbconnect.php');

if(isset($_GET['token'])){
    $token = $_GET['token'];

    $sql = "SELECT * FROM tbl_userregistration WHERE verification_token = ? AND is_verified = 0 LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $user_id = $user['id'];

        // ব্যবহারকারীকে ভেরিফাইড হিসেবে আপডেট করা হচ্ছে
        $update_sql = "UPDATE tbl_userregistration SET is_verified = 1 WHERE id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "i", $user_id);
        
        if(mysqli_stmt_execute($update_stmt)){
            // ভেরিফিকেশন সফল হলে লগইন পেজে পাঠানো হচ্ছে
            header("Location: login.php?verified=true");
            exit();
        }
    } else {
        die("Invalid or expired verification link.");
    }
} else {
    die("Verification token not found.");
}
?>