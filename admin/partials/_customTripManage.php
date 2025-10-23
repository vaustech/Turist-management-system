<?php
// ডাটাবেস কানেকশন ও সেশন চালু করা হচ্ছে
require_once('../../includes/_dbconnect.php');

// ===================================
//  স্ট্যাটাস আপডেট করার লজিক
// ===================================
if (isset($_POST['update_status'])) {
    $request_id = intval($_POST['request_id']);
    $new_status = $_POST['new_status'];

    // SQL Injection থেকে সুরক্ষার জন্য Prepared Statement
    $stmt = $conn->prepare("UPDATE tbl_customtrips SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $request_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Request status updated successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not update status.";
        $_SESSION['msg_type'] = 'danger';
    }
    $stmt->close();
    header("Location: ../customTripsManage.php");
    exit();
}

// ===================================
//  রিকোয়েস্ট ডিলিট করার লজিক
// ===================================
if (isset($_POST['delete_request'])) {
    $request_id = intval($_POST['request_id']);

    // SQL Injection থেকে সুরক্ষার জন্য Prepared Statement
    $stmt = $conn->prepare("DELETE FROM tbl_customtrips WHERE id = ?");
    $stmt->bind_param("i", $request_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Request deleted successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not delete request.";
        $_SESSION['msg_type'] = 'danger';
    }
    $stmt->close();
    header("Location: ../customTripsManage.php");
    exit();
}

// যদি কোনো কারণে সরাসরি এই ফাইলে আসা হয়, তাহলে রিডাইরেক্ট করা হবে
header("Location: ../customTripsManage.php");
exit();
?>