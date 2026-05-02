<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendOTP($to, $otp) {
    $mail = new PHPMailer(true);
    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'neha731784@gmail.com';
        $mail->Password   = 'bjxcuvmvgdedekia'; // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender & Receiver
        $mail->setFrom('neha731784@gmail.com', 'JS ITI Portal');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Password Reset OTP';
        $mail->Body    = "<h3>Account Recovery</h3>
                          <p>Your OTP for password reset is: <b>$otp</b></p>
                          <p>This code is valid for 2 minutes only.</p>";

        return $mail->send();
    } catch (Exception $e) {
        return false;
    }
}
?>