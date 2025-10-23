<?php
require_once('../../includes/_dbconnect.php');

// =================== CREATE CATEGORY ===================
if (isset($_POST['create_category'])) {
    $category_name = $_POST['category_name'];

    $sql = "INSERT INTO tbl_packagetype (package_type) VALUES (?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $category_name);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Category created successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not create category.";
        $_SESSION['msg_type'] = 'danger';
    }
    mysqli_stmt_close($stmt);
    header("Location: ../categoryManage.php");
    exit();
}


// =================== UPDATE CATEGORY (নতুন যোগ করা হয়েছে) ===================
if (isset($_POST['update_category'])) {
    $category_id = intval($_POST['category_id']);
    $category_name = $_POST['category_name'];

    $sql = "UPDATE tbl_packagetype SET package_type = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $category_name, $category_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Category updated successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not update category.";
        $_SESSION['msg_type'] = 'danger';
    }
    mysqli_stmt_close($stmt);
    header("Location: ../categoryManage.php");
    exit();
}





// =================== DELETE CATEGORY ===================
if (isset($_POST['delete_category'])) {
    $category_id = intval($_POST['category_id']);

    // IMPORTANT: Check if the category is currently being used by any package.
    $check_sql = "SELECT COUNT(*) as count FROM tbl_tourpackage WHERE package_type = ?";
    $stmt_check = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt_check, "i", $category_id);
    mysqli_stmt_execute($stmt_check);
    $result = mysqli_stmt_get_result($stmt_check);
    $count = mysqli_fetch_assoc($result)['count'];
    mysqli_stmt_close($stmt_check);

    if ($count > 0) {
        // If the category is in use, prevent deletion.
        $_SESSION['message'] = "Cannot delete this category because it is currently assigned to " . $count . " package(s).";
        $_SESSION['msg_type'] = 'danger';
    } else {
        // If not in use, proceed with deletion.
        $sql = "DELETE FROM tbl_packagetype WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $category_id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Category deleted successfully!";
        } else {
            $_SESSION['message'] = "Error deleting category.";
            $_SESSION['msg_type'] = 'danger';
        }
        mysqli_stmt_close($stmt);
    }

    header("Location: ../categoryManage.php");
    exit();
}
?>