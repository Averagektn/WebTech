<?php
require 'PHPMailer.php';
require  'SMTP.php';
require  'Exception.php';

function Send($name, $to, $body): void
{
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;

        $mail->Host = 'smtp.gmail.com';
        $mail->Username = "rUSERNAME";
        $mail->Password = "PASSWORD";
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom("USERNAME", $name);

        if (isset($_FILES['attachment'])) {
            foreach ($_FILES['attachment']['tmp_name'] as $index => $tmpName) {
                $attachmentName = $_FILES['attachment']['name'][$index];
                if (file_exists($tmpName)) {
                    $mail->addAttachment($tmpName, $attachmentName);
                }
            }
        }


        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = "TEST";
        $mail->Body = $body;

        if ($mail->send()) {
            echo "Sent successfully!";
        } else {
            echo "STILL ERROR";
        }
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        echo "Exception";
    }
}
