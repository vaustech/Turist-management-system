<?php
require_once('../../includes/_dbconnect.php');

// Delete User
if (isset($_POST['delete_user'])) {
    $user_id = intval($_POST['user_id']);

    $sql = "DELETE FROM tbl_userregistration WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    if(mysqli_stmt_execute($stmt)){
        $_SESSION['message'] = "User deleted successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not delete user.";
    }
    mysqli_stmt_close($stmt);
    header("Location: ../userManage.php");
    exit();
}
?>