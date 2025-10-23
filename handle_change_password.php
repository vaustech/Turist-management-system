<?php
require_once('includes/_dbconnect.php');

if(isset($_POST['change_password'])){
    if(!isset($_SESSION['user_loggedin']) || $_SESSION['user_loggedin'] != true){
        header("Location: login.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password != $confirm_password) {
        // Handle error: Passwords do not match
        header("Location: change-password.php?error=mismatch");
        exit();
    }

    $sql = "SELECT password FROM tbl_userregistration WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = $result->fetch_assoc();

    if ($user && password_verify($current_password, $user['password'])) {
        // Current password is correct, now update with the new password
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $sql_update = "UPDATE tbl_userregistration SET password = ? WHERE id = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "si", $new_hashed_password, $user_id);

        if(mysqli_stmt_execute($stmt_update)){
            // Password updated successfully
            header("Location: profile.php?pass_success=true");
            exit();
        } else {
            // Handle error: DB update failed
            header("Location: change-password.php?error=db");
            exit();
        }
    } else {
        // Handle error: Incorrect current password
        header("Location: change-password.php?error=incorrect");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>