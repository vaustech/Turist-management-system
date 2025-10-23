<?php
// This is a self-contained test file. No other files are needed.
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- Step 1: Database Connection (Directly in this file) ---
    $db_server = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "tms_db";
    $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

    if (!$conn) {
        die("DATABASE CONNECTION FAILED: " . mysqli_connect_error());
    }

    // --- Step 2: Get Form Data ---
    $username = $_POST['username'];
    $password_plain = $_POST['password'];

    // --- Step 3: Hash the Password ---
    $password_hashed = md5($password_plain);

    // --- Step 4: Query the Database ---
    $sql = "SELECT * FROM tbl_admin WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password_hashed);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // --- Step 5: Check the Result ---
    if (mysqli_num_rows($result) == 1) {
        $message = "<h3 style='color:green;'>লগইন সফল হয়েছে! (Login Successful!)</h3>";
        $message .= "<p>এর মানে হলো আপনার ডাটাবেস এবং পাসওয়ার্ড হ্যাশ সঠিক আছে। মূল সমস্যাটি আপনার পুরোনো ফাইলগুলোর পাথ (path) বা লিঙ্কিং এ ছিল।</p>";
    } else {
        $message = "<h3 style='color:red;'>লগইন ব্যর্থ হয়েছে! (Login Failed!)</h3>";
        $message .= "<p><b>প্রবেশ করানো ইউজারনেম:</b> " . htmlspecialchars($username) . "</p>";
        $message .= "<p><b>প্রবেশ করানো পাসওয়ার্ড থেকে তৈরি হওয়া হ্যাশ:</b> " . $password_hashed . "</p>";
        $message .= "<p>অনুগ্রহ করে phpMyAdmin-এ গিয়ে নিশ্চিত করুন ডাটাবেসে এই হ্যাশটিই আছে।</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Final Login Test</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style> body { padding: 40px; background-color: #f0f2f5; } </style>
</head>
<body>
    <div class="container bg-white" style="max-width: 500px; margin: auto; border: 1px solid #ddd; padding: 30px; border-radius: 10px;">
        <h2 class="text-center">Final Admin Login Test</h2>
        <hr>
        
        <?php if(!empty($message)) { echo "<div class='alert " . (strpos($message, 'Successful') ? 'alert-success' : 'alert-danger') . "'>" . $message . "</div>"; } ?>

        <form action="test_login.php" method="POST"> <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required value="admin">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Test Login</button>
        </form>
    </div>
</body>
</html>