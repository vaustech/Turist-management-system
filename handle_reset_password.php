<?php
require_once('includes/_dbconnect.php');

if (isset($_POST['reset_password'])) {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password != $confirm_password) {
        die("Passwords do not match. Please go back and try again.");
    }

    // টোকেনটি বৈধ এবং মেয়াদোত্তীর্ণ নয় কিনা তা চেক করা
    $current_time = date("Y-m-d H:i:s");
    $sql = "SELECT id FROM tbl_userregistration WHERE reset_token = ? AND reset_token_expiry > ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $token, $current_time);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $user_id = $user['id'];
        
        // নতুন পাসওয়ার্ড হ্যাশ করে ডাটাবেস আপডেট করা
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE tbl_userregistration SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "si", $hashed_password, $user_id);

        if (mysqli_stmt_execute($update_stmt)) {
            // সফলভাবে পাসওয়ার্ড পরিবর্তন হলে লগইন পেজে পাঠানো
            header("Location: login.php?reset_success=true");
            exit();
        }
    } else {
        die("Invalid or expired reset link. Please try again.");
    }
}
?>