<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $mail = new PHPMailer(true);

    try {
        //server setup
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your_email'; //
        $mail->Password   = 'your_password ';        //
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // set receiver
        $mail->setFrom('youremail@example.com', 'Web Contact');
        $mail->addAddress('youremail@example.com'); //
        $mail->addReplyTo($data['email'], $data['name']);      //

        // set content
        $mail->isHTML(false);
        $mail->Subject = "[Contact Us] " . $data['name'] . " has sent a query";
        $mail->Body    = "Name: {$data['name']}\nEmail: {$data['email']}\n\nMessage:\n{$data['message']}";

        $mail->send();
        http_response_code(200);
        echo json_encode(["message" => "success"]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "fail: " . $mail->ErrorInfo]);
    }
}
?>
