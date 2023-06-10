<?php
if (isset($_GET["file"])) {
    $dir = "uploads/"; // путь к директории с загруженными файлами
    $file = $_GET["file"];
    $path = $dir . $file;
    if (file_exists($path)) {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$file\"");
        readfile($path);
        exit();
    }
}