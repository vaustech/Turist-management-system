<?php
require_once('includes/_dbconnect.php');

if (isset($_POST['submit_testimonial'])) {
    if(!isset($_SESSION['user_loggedin']) || $_SESSION['user_loggedin'] != true){
        header("Location: login.php");
        exit;
    }

    $user_name = $_SESSION['user_name']; // Get user's name from session
    $message = $_POST['message'];
    $image_name = 'default_user.png'; // Default image
    $rating = $_POST['rating'];

    // Handle optional image upload
    if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] == 0) {
        $target_dir = "uploads/testimonials/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_name = time() . '_' . basename($_FILES["user_image"]["name"]);
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES["user_image"]["tmp_name"], $target_file);
    }

    // Insert testimonial into the database with 'Pending' status (0)
    $sql = "INSERT INTO tbl_testimonials (user_name, user_image, rating, message, status) VALUES (?, ?, ?, ?, 0)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssis", $user_name, $image_name, $rating, $message);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: profile.php?testimonial_success=true");
    } else {
        die("Error: Could not submit your review.");
    }
}

?>