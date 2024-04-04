<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../lib/PHPMailer/src/Exception.php';
require '../../lib/PHPMailer/src/PHPMailer.php';
require '../../lib/PHPMailer/src/SMTP.php';
require '../../config.php';

if (isset($_POST['send_test_email'])) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER; // Replace with your email
        $mail->Password   = SMTP_PASS; // Replace with your password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom(MAIL_FROM_EMAIL, 'Mailer');
        $mail->addAddress('direwolf541@gmail.com', 'Joe User'); // Replace with recipient's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Test Email Subject';
        $mail->Body    = 'This is a test email body in <b>HTML</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}