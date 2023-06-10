<?php
function generateThumbnail($sourceImage, $thumbnailWidth, $thumbnailHeight): string
{
    $extension = strtolower(pathinfo($sourceImage, PATHINFO_EXTENSION));

    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            $image = imagecreatefromjpeg($sourceImage);
            break;
        case 'png':
            $image = imagecreatefrompng($sourceImage);
            break;
        case 'gif':
            $image = imagecreatefromgif($sourceImage);
            break;
        default:
            throw new Exception('Unsupported image extension');
    }

    $width = imagesx($image);
    $height = imagesy($image);

    $thumbnail = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);

    imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $thumbnailWidth, $thumbnailHeight, $width, $height);

    $thumbnailPath = 'thumbnails/' . date('h-i-sA') . '.' . $extension;

    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            imagejpeg($thumbnail, $thumbnailPath);
            break;
        case 'png':
            imagepng($thumbnail, $thumbnailPath);
            break;
        case 'gif':
            imagegif($thumbnail, $thumbnailPath);
            break;
    }

    imagedestroy($image);
    imagedestroy($thumbnail);

    return $thumbnailPath;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image'])) {
        $sourceImage = $_FILES['image']['tmp_name'];
        $thumbnailWidth = $_POST['width'];
        $thumbnailHeight = $_POST['height'];

        $thumbnailPath = generateThumbnail($sourceImage, $thumbnailWidth, $thumbnailHeight);

        echo '<img src="' . $thumbnailPath . '" style="max-width: 100%; height: auto;">';
    }
}

