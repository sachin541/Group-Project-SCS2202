<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../lib/PHPMailer/src/Exception.php';
require '../../lib/PHPMailer/src/PHPMailer.php';
require '../../lib/PHPMailer/src/SMTP.php';
// require '../../config.php'; The database class alreay requires this 

function sendEmail($recipientEmail, $Subject, $Body) {
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
        $mail->Subject = $Subject;
        $mail->Body    = $Body;
        $mail->AltBody = $Body;

        $mail->send();
        return true; // Return true on success
    } catch (Exception $e) {
        // Return the error message in case of failure
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

