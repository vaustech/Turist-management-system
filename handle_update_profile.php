<?php
// ডাটাবেস কানেকশন ও সেশন চালু করা হচ্ছে
require_once('includes/_dbconnect.php');

// ব্যবহারকারী লগইন করা না থাকলে বা ফর্ম সাবমিট না হলে তাকে ফেরত পাঠানো হবে
if (!isset($_SESSION['user_loggedin']) || $_SESSION['user_loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['update_profile'])) {
    // সেশন থেকে ব্যবহারকারীর আইডি নেওয়া হচ্ছে
    $user_id = $_SESSION['user_id'];

    // ফর্ম থেকে আসা নতুন তথ্যগুলো নেওয়া হচ্ছে
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    // সাধারণ ভ্যালিডেশন
    if (empty($name) || empty($email) || empty($mobile)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: profile.php");
        exit();
    }

    // ডাটাবেসে তথ্য আপডেট করার জন্য Prepared Statement
    $stmt = $conn->prepare("UPDATE tbl_userregistration SET name = ?, emailid = ?, mobile = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $mobile, $user_id);

    if ($stmt->execute()) {
        // ডাটাবেস আপডেট সফল হলে, সেশনের নামও আপডেট করা হচ্ছে
        $_SESSION['user_name'] = $name;
        $_SESSION['message'] = "Profile updated successfully!";
    } else {
        $_SESSION['error'] = "Error: Could not update profile.";
    }

    $stmt->close();
    header("Location: profile.php");
    exit();

} else {
    // যদি কেউ সরাসরি এই পেজে আসার চেষ্টা করে
    header("Location: index.php");
    exit();
}
?>