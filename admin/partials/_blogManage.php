<?php
require_once('../../includes/_dbconnect.php');

// Helper function to delete image
function deleteBlogImage($filename) {
    if (empty($filename)) return;
    $filepath = "../../uploads/blog/" . $filename;
    if (file_exists($filepath) && is_file($filepath)) {
        unlink($filepath);
    }
}

// === ADD NEW POST ===
if (isset($_POST['add_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_name = $_POST['author_name'];
    $tags = $_POST['tags'];
    $status = $_POST['status'];

    $image_name = time() . '_' . basename($_FILES["featured_image"]["name"]);
    $target_dir = "../../uploads/blog/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["featured_image"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO tbl_blog (title, content, author_name, tags, featured_image, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $title, $content, $author_name, $tags, $image_name, $status);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: ../blogManage.php");
    exit();
}

// === UPDATE POST ===
if (isset($_POST['update_post'])) {
    $post_id = intval($_POST['post_id']);
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_name = $_POST['author_name'];
    $tags = $_POST['tags'];
    $status = $_POST['status'];
    $old_image = $_POST['old_image'];
    
    $final_image = $old_image;

    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] == 0) {
        $new_image_name = time() . '_' . basename($_FILES["featured_image"]["name"]);
        $target_dir = "../../uploads/blog/";
        $target_file = $target_dir . $new_image_name;

        if (move_uploaded_file($_FILES["featured_image"]["tmp_name"], $target_file)) {
            deleteBlogImage($old_image);
            $final_image = $new_image_name;
        }
    }

    $stmt = $conn->prepare("UPDATE tbl_blog SET title=?, content=?, author_name=?, tags=?, featured_image=?, status=? WHERE id=?");
    $stmt->bind_param("sssssii", $title, $content, $author_name, $tags, $final_image, $status, $post_id);
    $stmt->execute();
    $stmt->close();
    header("Location: ../blogManage.php");
    exit();
}

// === DELETE POST ===
if (isset($_POST['delete_post'])) {
    $post_id = intval($_POST['post_id']);

    $stmt_img = $conn->prepare("SELECT featured_image FROM tbl_blog WHERE id = ?");
    $stmt_img->bind_param("i", $post_id);
    $stmt_img->execute();
    $result_img = $stmt_img->get_result();
    if ($row_img = $result_img->fetch_assoc()) {
        deleteBlogImage($row_img['featured_image']);
    }
    $stmt_img->close();

    $stmt = $conn->prepare("DELETE FROM tbl_blog WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->close();
    header("Location: ../blogManage.php");
    exit();
}
?>
