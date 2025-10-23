<?php
require_once('../../includes/_dbconnect.php');

if(isset($_POST['upload_images'])) {
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $upload_dir = "../../uploads/gallery/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $uploaded_files = [];
    foreach($_FILES['images']['name'] as $key => $name) {
        $tmp_name = $_FILES['images']['tmp_name'][$key];
        $target_file = $upload_dir . basename($name);

        if(move_uploaded_file($tmp_name, $target_file)) {
            $uploaded_files[] = basename($name);
        }
    }

    if (!empty($uploaded_files)) {
        $image_string = implode(",", $uploaded_files);

        // Check if location exists
        $check_sql = "SELECT * FROM tbl_gallery WHERE location = ?";
        $stmt_check = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($stmt_check, "s", $location);
        mysqli_stmt_execute($stmt_check);
        $result = mysqli_stmt_get_result($stmt_check);

        if(mysqli_num_rows($result) > 0) {
            // Update existing record
            $row = mysqli_fetch_assoc($result);
            $new_images = $row['images'] . "," . $image_string;
            $update_sql = "UPDATE tbl_gallery SET images = ? WHERE location = ?";
            $stmt_update = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($stmt_update, "ss", $new_images, $location);
            mysqli_stmt_execute($stmt_update);
        } else {
            // Insert new record
            $insert_sql = "INSERT INTO tbl_gallery (location, images) VALUES (?, ?)";
            $stmt_insert = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($stmt_insert, "ss", $location, $image_string);
            mysqli_stmt_execute($stmt_insert);
        }
        $_SESSION['message'] = "Images uploaded successfully!";
        $_SESSION['msg_type'] = 'success';
    } else {
        $_SESSION['message'] = "Failed to upload images.";
        $_SESSION['msg_type'] = 'danger';
    }
    header('Location: ../galleryManage.php');
    exit();
}
?>