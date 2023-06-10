<?php
ini_set('display_errors', '0');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['directories']) && isset($_POST['interval'])) {
        $directories = explode(',', $_POST['directories']);
        $interval = intval($_POST['interval']);

        $backupDir = 'C:\WebData\lab8\task_3\backups';

        while (true) {
            $backupFileName = 'backup_' . date('Y-m-d_H-i-s') . '.zip';

            $zip = new ZipArchive();
            if ($zip->open($backupDir . '/' . $backupFileName, ZipArchive::CREATE) === true) {
                foreach ($directories as $directory) {
                    addFilesToZip($zip, trim($directory));
                }
                $zip->close();

                echo 'Archived!' . '<br>';
            } else {
                echo 'ERROR' . '<br>';
            }
            sleep($interval);
        }
    }

}

function addFilesToZip($zip, $source, $prefix = '') {
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = $prefix . '/' . substr($filePath, strlen($source) + 1);

            $zip->addFile($filePath, $relativePath);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Archives</title>
</head>
<body>
<h1>Archives</h1>
<form method="POST">
    <label for="directories">Paths(use comma for multiple paths):</label><br>
    <input type="text" id="directories" name="directories" required><br><br>

    <label for="interval">Time(in seconds):</label><br>
    <input type="number" id="interval" name="interval" required><br><br>

    <input type="submit" value="Start">
</form>
</body>
</html>
