<?php
require_once('../../includes/_dbconnect.php');

// Function to safely delete an image file
function deleteImage($filename) {
    if (empty($filename)) return;
    $filepath = "../../uploads/" . $filename;
    if (file_exists($filepath) && is_file($filepath)) {
        unlink($filepath);
    }
}

// =================== CREATE PACKAGE ===================
if (isset($_POST['create_package'])) {
    $package_name = $_POST['package_name'];
    $package_type = $_POST['package_type'];
    $package_location = $_POST['package_location'];
    $package_price = $_POST['package_price'];
    $package_details = $_POST['package_details'];
    $package_image = $_FILES['package_image']['name'];

    // Image Upload
    $target_dir = "../../uploads/";
    $target_file = $target_dir . basename($package_image);
    
    if (move_uploaded_file($_FILES['package_image']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO tbl_tourpackage (package_name, package_type, package_location, package_price, package_details, package_image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sisiss", $package_name, $package_type, $package_location, $package_price, $package_details, $package_image);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Package created successfully!";
        } else {
            $_SESSION['message'] = "Error: Could not create package.";
            deleteImage($package_image); // Delete uploaded image if DB insert fails
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = "Sorry, there was an error uploading your file.";
    }
    header("Location: ../packageManage.php");
    exit();
}

// =================== UPDATE PACKAGE ===================
if (isset($_POST['update_package'])) {
    $package_id = intval($_POST['package_id']);
    $package_name = $_POST['package_name'];
    $package_type = $_POST['package_type'];
    $package_location = $_POST['package_location'];
    $package_price = $_POST['package_price'];
    $package_details = $_POST['package_details'];
    $old_image = $_POST['old_image'];
    $new_image = $_FILES['package_image']['name'];

    $final_image = $old_image;

    if (!empty($new_image)) {
        $target_dir = "../../uploads/";
        $target_file = $target_dir . basename($new_image);
        if (move_uploaded_file($_FILES['package_image']['tmp_name'], $target_file)) {
            deleteImage($old_image); // Delete the old image
            $final_image = $new_image;
        }
    }

    $sql = "UPDATE tbl_tourpackage SET package_name=?, package_type=?, package_location=?, package_price=?, package_details=?, package_image=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sisissi", $package_name, $package_type, $package_location, $package_price, $package_details, $final_image, $package_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Package updated successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not update package.";
    }
    mysqli_stmt_close($stmt);
    header("Location: ../packageManage.php");
    exit();
}
// =================== DELETE PACKAGE ===================
if (isset($_POST['delete_package'])) {
    $package_id = intval($_POST['package_id']);

    // First, get the image filename to delete it from the server
    $sql_img = "SELECT package_image FROM tbl_tourpackage WHERE id = ?";
    $stmt_img = mysqli_prepare($conn, $sql_img);
    mysqli_stmt_bind_param($stmt_img, "i", $package_id);
    mysqli_stmt_execute($stmt_img);
    $result_img = mysqli_stmt_get_result($stmt_img);
    if ($row_img = mysqli_fetch_assoc($result_img)) {
        deleteImage($row_img['package_image']);
    }
    mysqli_stmt_close($stmt_img);

    // Now, delete the record from the database
    $sql = "DELETE FROM tbl_tourpackage WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $package_id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Package deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting package.";
    }
    mysqli_stmt_close($stmt);
    header("Location: ../packageManage.php");
    exit();
}
?>