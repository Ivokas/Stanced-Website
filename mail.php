<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$response = ["success" => false, "message" => "Something went wrong"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $messagecontent = "Name = " . $name . "<br>Email = " . $email . "<br>Message = " . $message;
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = 'e09b703dd5babb';
        $mail->Password = 'bdda96edc6d356';
        $mail->Port = 2525;

        $mail->setFrom('suggestion@stanced.com', 'suggestion');
        $mail->addAddress('inbox@stanced.com', 'inbox');

        $mail->isHTML(true);
        $mail->Subject = 'Suggestion';
        $mail->Body = $messagecontent;

        if ($mail->send()) {
            $response["success"] = true;
            $response["message"] = "Message sent successfully!";
        }
    } catch (Exception $e) {
        $response["message"] = "Message could not be sent. Error: {$mail->ErrorInfo}";
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
