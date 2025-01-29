<?php
define('DB_HOST', '127.0.0.1:3306:3306');  // Updated to include port
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tech_training');

// Add development mode setting
define('DEV_MODE', $_SERVER['SERVER_NAME'] === '127.0.0.1:3306');

// Add error reporting for development
if (DEV_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
}
?>