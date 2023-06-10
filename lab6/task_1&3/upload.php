<?php
if (isset($_FILES["file"])) {
    $dir = "uploads/"; // путь к директории, куда будут загружаться файлы
    $file = $_FILES["file"]["name"];
    move_uploaded_file($_FILES["file"]["tmp_name"], $dir . $file);
    header("Location: file_manager.php"); // перенаправляем пользователя на главную страницу
}