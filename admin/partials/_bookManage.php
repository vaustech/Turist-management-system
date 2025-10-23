<?php
require_once('../../includes/_dbconnect.php');

// PHPMailer এবং mpdf লাইব্রেরি যুক্ত করা হচ্ছে
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../includes/PHPMailer/src/Exception.php';
require '../../includes/PHPMailer/src/PHPMailer.php';
require '../../includes/PHPMailer/src/SMTP.php';

// ===== Composer এর autoload.php ফাইলের নতুন এবং সঠিক পাথ =====
require_once __DIR__ . '/../../vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();


// =================== Confirm Booking ===================
if (isset($_POST['confirm_booking'])) {
    $booking_id = intval($_POST['booking_id']);
    
    // বুকিংয়ের বিস্তারিত তথ্য ডাটাবেস থেকে আনা হচ্ছে
    $sql = "SELECT b.*, u.name as user_name, u.emailid as user_email, p.package_name, p.package_price 
            FROM tbl_booking b
            JOIN tbl_userregistration u ON b.user_id = u.id
            JOIN tbl_tourpackage p ON b.package_id = p.id
            WHERE b.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $booking_details = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($booking_details) {
        // ইনভয়েসের জন্য ডেটা প্রস্তুত করা হচ্ছে
        $total_cost = $booking_details['package_price'] * $booking_details['num_people'];
        $balance_due = $total_cost - $booking_details['paid_amount'];

        // ইনভয়েস টেমপ্লেট পড়া হচ্ছে
        $invoice_html = file_get_contents('invoice_template.php');
        
        // টেমপ্লেটে ডেটা বসানো হচ্ছে
        $invoice_html = str_replace('{{customer_name}}', $booking_details['user_name'], $invoice_html);
        $invoice_html = str_replace('{{customer_email}}', $booking_details['user_email'], $invoice_html);
        $invoice_html = str_replace('{{invoice_id}}', $booking_details['id'], $invoice_html);
        $invoice_html = str_replace('{{invoice_date}}', date('d M, Y'), $invoice_html);
        $invoice_html = str_replace('{{package_name}}', $booking_details['package_name'], $invoice_html);
        $invoice_html = str_replace('{{trip_date}}', date('d M, Y', strtotime($booking_details['from_date'])), $invoice_html);
        $invoice_html = str_replace('{{num_people}}', $booking_details['num_people'], $invoice_html);
        $invoice_html = str_replace('{{package_price}}', number_format($booking_details['package_price']), $invoice_html);
        $invoice_html = str_replace('{{total_cost}}', number_format($total_cost), $invoice_html);
        $invoice_html = str_replace('{{paid_amount}}', number_format($booking_details['paid_amount']), $invoice_html);
        $invoice_html = str_replace('{{balance_due}}', number_format($balance_due), $invoice_html);

        // mpdf ব্যবহার করে পিডিএফ তৈরি করা হচ্ছে
        
        $mpdf->WriteHTML($invoice_html);
        $pdf_content = $mpdf->Output('', 'S');

        // PHPMailer ব্যবহার করে ইমেইল পাঠানো হচ্ছে
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'cogentpwad@gmail.com'; 
            $mail->Password   = 'ppyvvdnmvtuetjtg';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            
            $mail->setFrom('cogentpwad@gmail.com', 'Porjotok');
            $mail->addAddress($booking_details['user_email'], $booking_details['user_name']);
            
            $mail->addStringAttachment($pdf_content, 'invoice-TMS-'.$booking_id.'.pdf');
            
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Your Booking is Confirmed!';
            $mail->Body    = 'Dear ' . $booking_details['user_name'] . ',<br><br>Your booking for the package "<b>' . $booking_details['package_name'] . '</b>" has been confirmed. Please find the attached invoice for details.<br><br>Thank you!';
            $mail->send();
            $_SESSION['message'] = 'Booking confirmed and invoice sent to the customer!';
        } catch (Exception $e) {
            $_SESSION['message'] = "Booking confirmed, but failed to send email. Mailer Error: {$mail->ErrorInfo}";
            $_SESSION['msg_type'] = 'danger';
        }

        // বুকিং স্ট্যাটাস আপডেট করা হচ্ছে
        $stmt_update = $conn->prepare("UPDATE tbl_booking SET status = 1 WHERE id = ?");
        $stmt_update->bind_param("i", $booking_id);
        $stmt_update->execute();
        $stmt_update->close();
    } else {
        $_SESSION['message'] = "Could not find booking details to generate invoice.";
        $_SESSION['msg_type'] = 'danger';
    }

    header("Location: ../bookingManage.php");
    exit();
}


// Confirm Booking
if (isset($_POST['confirm_booking'])) {
    $booking_id = intval($_POST['booking_id']);
    $status = 1; // 1 for Confirmed

    $sql = "UPDATE tbl_booking SET status = ? WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $status, $booking_id);

    if(mysqli_stmt_execute($stmt)){
        $_SESSION['message'] = "Booking confirmed successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not update booking status.";
    }
    mysqli_stmt_close($stmt);
    header("Location: ../bookingManage.php");
    exit();
}

// Cancel Booking
if (isset($_POST['cancel_booking'])) {
    $booking_id = intval($_POST['booking_id']);
    $status = 2; // 2 for Cancelled

    $sql = "UPDATE tbl_booking SET status = ? WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $status, $booking_id);

    if(mysqli_stmt_execute($stmt)){
        $_SESSION['message'] = "Booking cancelled successfully!";
    } else {
        $_SESSION['message'] = "Error: Could not update booking status.";
    }
    mysqli_stmt_close($stmt);
    header("Location: ../bookingManage.php");
    exit();
}
?>