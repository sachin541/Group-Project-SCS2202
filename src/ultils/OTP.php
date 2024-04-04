<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../lib/PHPMailer/src/Exception.php';
require '../../lib/PHPMailer/src/PHPMailer.php';
require '../../lib/PHPMailer/src/SMTP.php';
require '../../config.php';

function sendOtpEmail($recipientEmail, $otp) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // From config.php
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER; // From config.php
        $mail->Password   = SMTP_PASS; // From config.php
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // From config.php, e.g., PHPMailer::ENCRYPTION_SMTPS
        $mail->Port       = 465; // From config.php, e.g., 465

        //Recipients
        $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME); // From config.php
        $mail->addAddress($recipientEmail); // Use the function's parameter

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Registration';
        $mail->Body    = "Hello, <br>Your One-Time Password (OTP) for registration is: <b>$otp</b>.<br>This OTP is valid for 10 minutes.";
        $mail->AltBody = "Hello, Your One-Time Password (OTP) for registration is: $otp. This OTP is valid for 10 minutes.";

        $mail->send();
        return true; // Return true on success
    } catch (Exception $e) {
        // Return the error message in case of failure
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Example usage:
// $otp = rand(100000, 999999); // Generate OTP
// $sendStatus = sendOtpEmail('recipient@example.com', $otp);
// if($sendStatus === true) {
//     echo 'OTP has been sent.';
// } else {
//     echo $sendStatus; // Prints the error message if sending failed
// }
