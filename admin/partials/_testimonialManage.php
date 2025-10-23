<?php
require_once('../../includes/_dbconnect.php');

// Approve Testimonial
if (isset($_POST['approve_testimonial'])) {
    $testimonial_id = intval($_POST['testimonial_id']);
    $status = 1; // 1 for Approved

    $sql = "UPDATE tbl_testimonials SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $status, $testimonial_id);

    if(mysqli_stmt_execute($stmt)){
        $_SESSION['message'] = "Testimonial approved successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not update status.";
        $_SESSION['msg_type'] = 'danger';
    }
    mysqli_stmt_close($stmt);
    header("Location: ../testimonialManage.php");
    exit();
}

// Delete Testimonial
if (isset($_POST['delete_testimonial'])) {
    $testimonial_id = intval($_POST['testimonial_id']);

    $sql = "DELETE FROM tbl_testimonials WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $testimonial_id);

    if(mysqli_stmt_execute($stmt)){
        $_SESSION['message'] = "Testimonial deleted successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not delete testimonial.";
        $_SESSION['msg_type'] = 'danger';
    }
    mysqli_stmt_close($stmt);
    header("Location: ../testimonialManage.php");
    exit();
}
?>