<?php
define('BASE_URL', 'http://localhost/tms_project/');
require_once('includes/_dbconnect.php');

// PHPMailer ক্লাসগুলো ব্যবহার করার জন্য ঘোষণা
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer ফাইলগুলো রিকোয়ার করা হচ্ছে
require 'includes/PHPMailer/src/Exception.php';
require 'includes/PHPMailer/src/PHPMailer.php';
require 'includes/PHPMailer/src/SMTP.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // পাসওয়ার্ড দুটি মিলছে কিনা তা চেক করা
    if ($password != $confirm_password) {
        die("Error: Passwords do not match. Please go back and try again.");
    }
    
    // ইমেইলটি আগে থেকেই রেজিস্টার করা আছে কিনা তা চেক করা
    $existSql = "SELECT * FROM `tbl_userregistration` WHERE emailid = ?";
    $stmt = mysqli_prepare($conn, $existSql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){
        die("Error: This email is already registered. Please use a different email or login.");
    } else {
        // নতুন ব্যবহারকারীর জন্য ডেটা প্রস্তুত করা
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $verification_token = bin2hex(random_bytes(16));

        // ডাটাবেসে নতুন ব্যবহারকারীর তথ্য প্রবেশ করানো হচ্ছে
        $sql = "INSERT INTO `tbl_userregistration` (name, emailid, mobile, password, verification_token, is_verified) VALUES (?, ?, ?, ?, ?, 0)";
        $stmt_insert = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt_insert, "sssss", $name, $email, $mobile, $hash, $verification_token);
        
        // যদি ডাটাবেসে তথ্য প্রবেশ সফল হয়
        if(mysqli_stmt_execute($stmt_insert)){
            // --- ইমেইল পাঠানোর কোড ---
            $mail = new PHPMailer(true);
            try {
                // সার্ভার সেটিংস
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'cogentpwad@gmail.com'; // ❗️ আপনার নিজের জিমেইল অ্যাড্রেস দিন
                $mail->Password   = 'ppyvvdnmvtuetjtg';   // ❗️ আপনার তৈরি করা ১৬ ডিজিটের App Password দিন
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // প্রাপক
                $mail->setFrom('YOUR_GMAIL_ADDRESS@gmail.com', 'TMS Website');
                $mail->addAddress($email, $name);

                // ইমেইলের কন্টেন্ট
                $mail->isHTML(true);
                $mail->Subject = 'Verify Your Email Address for TMS Website';
                $verification_link = BASE_URL . "verify.php?token=" . $verification_token;
                $mail->Body    = "Hello $name,<br><br>Welcome to our Tour Management System! Please click the link below to verify your email address:<br><br><a href='$verification_link'>Verify My Email</a><br><br>Thank you!";

                $mail->send();
                // ব্যবহারকারীকে সফল বার্তা দেখানো
               include 'includes/header.php'; // হেডার যুক্ত করা হলো
?>
<div class="container text-center py-5 my-5">
    <div class="success-icon mb-4">
        <i class="fas fa-check"></i>
    </div>
    <h1 class="display-4">Registration Successful!</h1>
    <p class="lead">A verification link has been sent to your email: <strong><?php echo htmlspecialchars($email); ?></strong></p>
    <hr>
    <p>Please check your inbox (and spam folder) to verify your account before logging in.</p>
    <p class="lead mt-4">
        <a class="btn btn-primary btn-lg" href="index.php" role="button">Continue to Homepage</a>
    </p>
</div>
<?php
include 'includes/footer.php'; 
                
            } catch (Exception $e) {
                echo "Registration was successful, but the verification email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error: Could not register user.";
        }
    }
}
?>