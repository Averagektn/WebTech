<?php
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

function Send($name, $to, $body): bool
{
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;

        $mail->Host = 'smtp.gmail.com';
        $mail->Username = "rylonoboev2004@gmail.com";
        $mail->Password = "hvzpmlxunihfynyy";
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->Subject = "WBCafe";
        $mail->setFrom("rylonoboev2004@gmail.com", $name);

        if (isset($_FILES['attachment'])) {
            foreach ($_FILES['attachment']['tmp_name'] as $index => $tmpName) {
                $attachmentName = $_FILES['attachment']['name'][$index];
                if (file_exists($tmpName)) {
                    $mail->addAttachment($tmpName, $attachmentName);
                }
            }
        }


        $mail->addAddress($to);

        $mail->isHTML();
        $mail->Body = $body;
        if (!$mail->send()) {
            return false;
        }
        return true;

    } catch (\PHPMailer\PHPMailer\Exception $e) {
        echo "Exception";
        return false;
    }
}