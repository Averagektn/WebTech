<?php
require  'MyMail.php';


session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['captcha']) && $_POST['captcha'] === $_SESSION['captcha']) {
        $name = $_POST['name'];
        $to = $_POST['email'];
        $message = $_POST['message'];
        $email = 'rylonoboev2004@gmail.com';
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=boundary123\r\n";

        $body = "Name: $name\r\n";
        $body .= "Email: $email\r\n";
        $body .= "Message: $message\r\n";
        $body .= "\r\n";

        if (isset($_FILES['attachment'])) {
            foreach ($_FILES['attachment']['tmp_name'] as $index => $tmpName) {
                $attachmentName = $_FILES['attachment']['name'][$index];
                if (file_exists($tmpName)){
                    $attachmentContent = file_get_contents($tmpName);
                    $attachmentContent = chunk_split(base64_encode($attachmentContent));
                }
            }
        }

        $mailSent = mail($to, 'TEST', $body, $headers);

        if ($mailSent) {
            unset($_SESSION['captcha']);
            echo 'Sent successfully!!!';
        } else {
            Send($name, $to, $body);
        }
    } else {
        echo 'Incorrect captcha';
    }
}