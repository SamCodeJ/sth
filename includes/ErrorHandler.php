<?php
class ErrorHandler {
    private $logFile;
    
    public function __construct() {
        // Create logs directory if it doesn't exist
        $logDir = __DIR__ . '/../logs';
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true);
        }
        
        $this->logFile = $logDir . '/error.log';
    }
    
    public function handleError($errno, $errstr, $errfile, $errline) {
        $message = date('Y-m-d H:i:s') . " [$errno] $errstr in $errfile on line $errline\n";
        error_log($message, 3, $this->logFile);
        
        if (in_array($errno, [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            die('An error occurred. Please try again later.');
        }
    }
}

// Set up error handling
$errorHandler = new ErrorHandler();
set_error_handler([$errorHandler, 'handleError']); 