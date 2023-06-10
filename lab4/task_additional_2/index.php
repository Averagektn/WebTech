<!--Создайте класс FileSystemObject, который позволял бы хранить имя, размер, тип объекта файловой системы,
а также возвращать размер в любых указанных еди-ницах (B, KB, MG, GB и т.д.).-->

<?php

require_once ('FileSystemObject.php');

$format = 'KB';
$current_dir = ".";
$files = FileSystemObject::listFiles($current_dir);
foreach ($files as $file) {
    $name = $file->getName();
    $size = $file->getSize($format);
    $type = $file->getType();
    echo "$name ($size $format, $type)\n" . '<br>';
}
