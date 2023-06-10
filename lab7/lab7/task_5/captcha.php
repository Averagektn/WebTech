<?php
session_start();

function generateRandomString($length = 6): string
{
    $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

// Random string
$captchaText = generateRandomString();

$_SESSION['captcha'] = $captchaText;

// Create image
$captchaImage = imagecreatetruecolor(200, 50);

// Fill background with white
$bgColor = imagecolorallocate($captchaImage, 255, 255, 255);
imagefill($captchaImage, 0, 0, $bgColor);

// Random lines
$lineColor = imagecolorallocate($captchaImage, 64, 64, 64);
for ($i = 0; $i < 5; $i++) {
    imageline($captchaImage, 0, rand() % 50, 200, rand() % 50, $lineColor);
}

// Random dots
$pointColor = imagecolorallocate($captchaImage, 0, 0, 255);
for ($i = 0; $i < 100; $i++) {
    imagesetpixel($captchaImage, rand() % 200, rand() % 50, $pointColor);
}

// Text
$textColor = imagecolorallocate($captchaImage, 0, 0, 0);
imagestring($captchaImage, 5, 50, 15, $captchaText, $textColor);
header('Content-type: image/png');
imagepng($captchaImage);
imagedestroy($captchaImage);