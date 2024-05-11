<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require_once './php/PHPMailer/src/PHPMailer.php';
require_once './php/PHPMailer/src/SMTP.php';
require_once './php/PHPMailer/src/Exception.php';

function sendEmail(
    $email,
    $subject,
    $body
) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'urvitgehlotug@gmail.com';
        $mail->Password   = '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
    
        $mail->setFrom('urvitgehlotug@gmail.com', 'Contact Us');
        $mail->addAddress($email);
    
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
    
        $mail->send();
        return true;
    } catch (Exception $e) {
        // echo .$e;
        return false;
    }
}