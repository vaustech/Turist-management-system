<?php
// ডাটাবেস কানেকশন ফাইল এবং সেশন চালু করা হচ্ছে
require_once('includes/_dbconnect.php');

// চেক করা হচ্ছে ফর্মটি POST মেথডে সাবমিট করা হয়েছে কিনা
if (isset($_POST['submit_trip_plan'])) {

    // সেশন থেকে ব্যবহারকারীর আইডি নেওয়া হচ্ছে (যদি লগইন করা থাকে)
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // ফর্ম থেকে আসা সব তথ্য ভেরিয়েবলে রাখা হচ্ছে
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $destination = $_POST['destination'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $num_travelers = $_POST['num_travelers'];
    $budget_per_person = $_POST['budget_per_person']; // নামের অমিলটি এখানে ঠিক করা হয়েছে
    $trip_type = $_POST['trip_type'];
    $interests = $_POST['interests'];

    // SQL Injection থেকে সুরক্ষিত থাকার জন্য Prepared Statement ব্যবহার করা হচ্ছে
    $sql = "INSERT INTO tbl_customtrips (user_id, full_name, email, phone, destination, from_date, to_date, num_travelers, budget_per_person, trip_type, interests) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    // ভেরিয়েবলগুলোকে SQL স্টেটমেন্টের সাথে বাইন্ড করা হচ্ছে
    // user_id Integer (i) হতে পারে অথবা NULL, তাই এখানে "issssssisss" ব্যবহার করা হয়েছে
    $stmt->bind_param("issssssisss", $user_id, $full_name, $email, $phone, $destination, $from_date, $to_date, $num_travelers, $budget_per_person, $trip_type, $interests);

    // স্টেটমেন্টটি execute করা হচ্ছে
    if ($stmt->execute()) {
        // সফলভাবে তথ্য সাবমিট হলে thank-you.php পেজে পাঠানো হবে
        header("Location: thank-you.php?trip_planned=true");
        exit();
    } else {
        // যদি কোনো এরর হয়
        die("Error: Could not process your request. Error: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

} else {
    // যদি কেউ সরাসরি এই পেজে আসার চেষ্টা করে, তাকে হোম পেজে পাঠানো হবে
    header("Location: index.php");
    exit();
}
?>