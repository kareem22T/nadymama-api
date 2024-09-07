<?php

namespace App\Traits;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

trait SendEmailTrait
{

    public function sendEmail($receiver_mail, $msg_title, $msg_content)
    {

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_LOWLEVEL; //Enable verbose debug output
            $mail->isSMTP(); //Send using SMTP
            $mail->Host = 'mail.nadymama.com'; //Set the SMTP server to send through
            $mail->SMTPAuth = true; //Enable SMTP authentication
            $mail->Username = 'mail@nadymama.com'; //SMTP username
            $mail->Password = '01119111893NaDy!mi'; //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
            $mail->Port = 465;
            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('mail@nadymama.com', 'Nady Mama');
            $mail->addAddress($receiver_mail); //Add a recipient
            $mail->CharSet = 'UTF-8';

            //Content
            $mail->isHTML(true);
            $mail->Subject = $msg_title;
            $mail->Body = $msg_content;
            $mail->SMTPDebug = 2;
            ob_start();
            $mail->send();
            $responsePayload = ob_get_clean();
            $mail->SMTPDebug = 0;
        } catch (Exception $e) {
            return [
                'status' => 500
            ];
        }
    }
}
