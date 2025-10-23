<?php
require_once('../../includes/_dbconnect.php');

// Mark as Read
if (isset($_POST['mark_read'])) {
    $query_id = intval($_POST['query_id']);
    $status = 1; // 1 for Read

    $sql = "UPDATE tbl_userquery SET status = ? WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $status, $query_id);

    if(mysqli_stmt_execute($stmt)){
        $_SESSION['message'] = "Query marked as read.";
    } else {
        $_SESSION['message'] = "Error: Could not update status.";
    }
    mysqli_stmt_close($stmt);
    header("Location: ../queryManage.php");
    exit();
}

// Delete Query
if (isset($_POST['delete_query'])) {
    $query_id = intval($_POST['query_id']);

    $sql = "DELETE FROM tbl_userquery WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $query_id);

    if(mysqli_stmt_execute($stmt)){
        $_SESSION['message'] = "Query deleted successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not delete query.";
    }
    mysqli_stmt_close($stmt);
    header("Location: ../queryManage.php");
    exit();
}
?>