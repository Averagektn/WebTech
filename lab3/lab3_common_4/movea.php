<?php

$filename = $_POST['filename'] ?? "";
$dir = $_POST['directory'] ?? "";

if (file_exists($filename) && is_dir($dir)){
    if (rename($filename, $dir.pathinfo($filename)['basename'])) {
        echo "Success";
    }
} elseif (!file_exists($filename)) {
    exit("File not found");
} else {
    exit("Incorrect directory path");
}