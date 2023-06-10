<?php

$filename = $_POST['filename'] ?? "";

if (file_exists($filename)){
    if (unlink($filename)) echo "Success";
} else {
    exit("Incorrect file path");
}