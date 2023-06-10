<?php

$dir = $_POST['dir'] ?? "";

if (is_dir($dir) && ($_FILES["file"]["error"] == 0)){
    $dir_to_save = $_POST['dir'];
    $save_path = "$dir_to_save/" . $_FILES["file"]["name"];

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $save_path)){
        echo "Success!<br>";

        if (str_starts_with($_FILES["file"]['type'], 'text')){
            $file = fopen($save_path, "r");
            $contents = fread($file, 30);
            fclose($file);
            echo $contents;
        } elseif (str_starts_with($_FILES["file"]['type'], 'image')){
            copy($save_path, "." . "\\" . pathinfo($save_path)['basename']);
            echo "<img src=\"" . pathinfo($save_path)['basename'] . "\">";
        }
    }
} elseif (!is_dir($dir)){
    exit("Incorrect directory path");
} else {
    exit("Loading error");
}