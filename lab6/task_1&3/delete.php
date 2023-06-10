<?php
if (isset($_GET["file"])) {
    $dir = "uploads/"; // путь к директории с загруженными файлами
    $file = $_GET["file"];
    $path = $dir . $file;
    if (file_exists($path)) {
        unlink($path); // удаляем файл с сервера
        header("Location: file_manager.php"); // перенаправляем пользователя на главную страницу
    }
}