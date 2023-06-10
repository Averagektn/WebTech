<?php

class FileSystemObject {
    private string $name;
    private int $size;
    private string $type;

    public function __construct($name, $size, $type) {
        $this->name = $name;
        $this->size = $size;
        $this->type = $type;
    }

    public function getName() {
        return $this->name;
    }

    public function getSize($unit = 'B') {
        switch ($unit) {
            case 'B':
                return $this->size;
            case 'KB':
                return round($this->size / 1024, 2);
            case 'MB':
                return round($this->size / 1024 / 1024, 2);
            case 'GB':
                return round($this->size / 1024 / 1024 / 1024, 2);
            default:
                return $this->size;
        }
    }

    public function getType() {
        return $this->type;
    }

    public static function calculateSize($path) {
        if (is_dir($path)) {
            $total_size = 0;
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file != "." && $file != "..") {
                    $total_size += self::calculateSize($path . DIRECTORY_SEPARATOR . $file);
                }
            }
            return $total_size;
        } else {
            return filesize($path);
        }
    }

    public static function listFiles($path) {
        $files = scandir($path);
        $file_objects = array();
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $file_path = $path . DIRECTORY_SEPARATOR . $file;
                $size = self::calculateSize($file_path);
                $type = is_dir($file_path) ? "dir" : "file";
                $file_objects[] = new FileSystemObject($file, $size, $type);
            }
        }
        return $file_objects;
    }
}
