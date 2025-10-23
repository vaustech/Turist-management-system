<?php
require_once('includes/_dbconnect.php');


define('BASE_URL', 'http://localhost/tms_project/'); // ✅ Add this line here


// PHPMailer ক্লাসগুলো ব্যবহার করার জন্য ঘোষণা
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'includes/PHPMailer/src/Exception.php';
require 'includes/PHPMailer/src/PHPMailer.php';
require 'includes/PHPMailer/src/SMTP.php';

if (isset($_POST['send_reset_link'])) {
    $email = $_POST['email'];

    // ইমেইলটি ডাটাবেসে আছে কিনা তা চেক করা
    $sql = "SELECT id FROM tbl_userregistration WHERE emailid = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // একটি সুরক্ষিত টোকেন এবং তার মেয়াদ তৈরি করা
        $token = bin2hex(random_bytes(32));
        $expiry_time = date("Y-m-d H:i:s", time() + 3600); // 1 hour expiry

        // ডাটাবেসে টোকেন এবং মেয়াদ সেভ করা
        $update_sql = "UPDATE tbl_userregistration SET reset_token = ?, reset_token_expiry = ? WHERE emailid = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "sss", $token, $expiry_time, $email);
        mysqli_stmt_execute($update_stmt);

        // --- ইমেইল পাঠানোর কোড ---
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'grabbanibisew@gmail.com'; // ❗️ আপনার জিমেইল
            $mail->Password   = 'xfyuerlochxgkjni';   // ❗️ আপনার App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('grabbanibisew@gmail.com', 'Porjotok Website');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $reset_link = BASE_URL . "reset-password.php?token=" . $token;
            $mail->Body    = "Hello,<br><br>We received a request to reset your password. Please click the link below to set a new password:<br><a href='$reset_link'>Reset Password</a><br><br>This link will expire in 1 hour.<br><br>Thank you!";
            
            $mail->send();
            
        } catch (Exception $e) {
            // ইমেইল পাঠাতে ব্যর্থ হলেও ব্যবহারকারীকে জানানো হবে না
        }
    }
    
    // ব্যবহারকারীকে একটি সাধারণ বার্তা দেখানো, যাতে তারা বুঝতে না পারে ইমেইলটি রেজিস্টার্ড কিনা
    header("Location: forgot-password.php?success=true");
    exit();
}
?>