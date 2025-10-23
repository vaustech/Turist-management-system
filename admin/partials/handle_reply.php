<?php
require_once('../../includes/_dbconnect.php');

// PHPMailer ফাইলগুলো ইম্পোর্ট করা হচ্ছে
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../includes/PHPMailer/src/Exception.php';
require '../../includes/PHPMailer/src/PHPMailer.php';
require '../../includes/PHPMailer/src/SMTP.php';

if (isset($_POST['send_reply'])) {
    $user_email = $_POST['user_email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cogentpwad@gmail.com'; 
        $mail->Password   = 'ppyvvdnmvtuetjtg';   // ❗️ আপনার তৈরি করা ১৬ ডিজিটের App Password দিন
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('cogentpwad@gmail.com', 'Porjotok_Admin'); // ❗️ প্রেরকের নাম ও ইমেইল
        $mail->addAddress($user_email);     // প্রাপকের ইমেইল

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        $_SESSION['message'] = 'Reply sent successfully!';
    } catch (Exception $e) {
        $_SESSION['message'] = "Reply could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $_SESSION['msg_type'] = 'danger';
    }

    header("Location: ../queryManage.php");
    exit();
}
?>