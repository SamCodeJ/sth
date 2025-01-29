<?php
require_once('Security.php');

class AuthMiddleware {
    private $security;

    public function __construct() {
        $this->security = new Security();
    }

    public function authenticate() {
        session_start();
        
        if (!isset($_SESSION['admin_session'])) {
            header('Location: login.php');
            exit();
        }

        if (!$this->security->validateSession($_SESSION['admin_session'])) {
            session_destroy();
            header('Location: login.php?error=session_expired');
            exit();
        }

        $this->security->updateSessionActivity($_SESSION['admin_session']);
    }
} 