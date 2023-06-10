<?php

class Logger {
    private bool $outputToScreen;
    private bool $outputToFile;
    private string $logFileName;

    public function __construct($outputToScreen = false, $outputToFile = false, $logFileName = 'log.txt') {
        $this->outputToScreen = $outputToScreen;
        $this->outputToFile = $outputToFile;
        $this->logFileName = $logFileName;
    }

    public function log($message): void {
        $timestamp = date('Y-m-d H:i:s');
        $message = "[{$timestamp}] {$message}\n";

        if ($this->outputToScreen) {
            echo $message;
        }

        if ($this->outputToFile) {
            file_put_contents($this->logFileName, $message, FILE_APPEND);
        }
    }
}