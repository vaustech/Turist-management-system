<?php
require_once('../../includes/_dbconnect.php');

// ফাংশন: ছবি ডিলিট করার জন্য
function deleteGuideImage($filename) {
    if (empty($filename)) return;
    $filepath = "../../uploads/guides/" . $filename;
    if (file_exists($filepath) && is_file($filepath)) {
        unlink($filepath);
    }
}

// =================== CREATE GUIDE ===================
if (isset($_POST['create_guide'])) {
    $guide_name = $_POST['guide_name'];
    $guide_specialty = $_POST['guide_specialty'];
    $display_order = $_POST['display_order'];
    
    // ছবি আপলোড লজিক
    $image_name = time() . '_' . basename($_FILES["guide_image"]["name"]);
    $target_dir = "../../uploads/guides/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["guide_image"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO tbl_guides (guide_name, guide_specialty, guide_image, display_order) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $guide_name, $guide_specialty, $image_name, $display_order);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Guide added successfully!";
        } else {
            $_SESSION['message'] = "Error: Could not add guide.";
            $_SESSION['msg_type'] = 'danger';
            deleteGuideImage($image_name);
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Sorry, there was an error uploading the image.";
        $_SESSION['msg_type'] = 'danger';
    }
    header("Location: ../guideManage.php");
    exit();
}

// =================== UPDATE GUIDE ===================
if (isset($_POST['update_guide'])) {
    $guide_id = intval($_POST['guide_id']);
    $guide_name = $_POST['guide_name'];
    $guide_specialty = $_POST['guide_specialty'];
    $display_order = $_POST['display_order'];
    $old_image = $_POST['old_image'];
    
    $final_image = $old_image;

    // যদি নতুন ছবি আপলোড করা হয়
    if (isset($_FILES['guide_image']) && $_FILES['guide_image']['error'] == 0) {
        $new_image_name = time() . '_' . basename($_FILES["guide_image"]["name"]);
        $target_dir = "../../uploads/guides/";
        $target_file = $target_dir . $new_image_name;

        if (move_uploaded_file($_FILES["guide_image"]["tmp_name"], $target_file)) {
            deleteGuideImage($old_image);
            $final_image = $new_image_name;
        }
    }

    $stmt = $conn->prepare("UPDATE tbl_guides SET guide_name=?, guide_specialty=?, guide_image=?, display_order=? WHERE id=?");
    $stmt->bind_param("sssii", $guide_name, $guide_specialty, $final_image, $display_order, $guide_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Guide updated successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not update guide.";
        $_SESSION['msg_type'] = 'danger';
    }
    $stmt->close();
    header("Location: ../guideManage.php");
    exit();
}

// =================== DELETE GUIDE ===================
if (isset($_POST['delete_guide'])) {
    $guide_id = intval($_POST['guide_id']);

    // ছবি ডিলিট করার জন্য প্রথমে ছবির নাম ডাটাবেস থেকে আনা হচ্ছে
    $stmt_img = $conn->prepare("SELECT guide_image FROM tbl_guides WHERE id = ?");
    $stmt_img->bind_param("i", $guide_id);
    $stmt_img->execute();
    $result_img = $stmt_img->get_result();
    if ($row_img = $result_img->fetch_assoc()) {
        deleteGuideImage($row_img['guide_image']);
    }
    $stmt_img->close();

    // ডাটাবেস থেকে রেকর্ড ডিলিট করা হচ্ছে
    $stmt = $conn->prepare("DELETE FROM tbl_guides WHERE id = ?");
    $stmt->bind_param("i", $guide_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Guide deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting guide.";
        $_SESSION['msg_type'] = 'danger';
    }
    $stmt->close();
    header("Location: ../guideManage.php");
    exit();
}
?>