<?php


use PHPMailer\PHPMailer\PHPMailer;

require '../lib/PHPMailer/src/PHPMailer.php';
require '../lib/PHPMailer/src/SMTP.php';
require '../lib/PHPMailer/src/Exception.php';


function email($email, $object, $body){

    include 'cnx.php';

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->Port = "465";
    $mail->Username = "starwarssae@gmail.com";
    $mail->Password = $password_mail;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

    $mail->setFrom('starwarssae@gmail.com', 'SAE-STARWARS');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = $object;
    $mail->Body = $body;

    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->send();
}

?>