<!DOCTYPE html>
<html>
<head>
    <title>File manager</title>
</head>
<body>
<h1>File manager</h1>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <button type="submit">Upload</button>
</form>
<hr>
<h2>Files:</h2>
<ul>
    <?php
    $dir = "uploads/"; // путь к директории с загруженными файлами
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            echo "<li>$file <a href=\"download.php?file=$file\">Download</a> <a href=\"delete.php?file=$file\">Delete</a></li>";
        }
    }
    ?>
</ul>
</body>
</html>
