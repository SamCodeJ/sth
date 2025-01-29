<?php
class Logger {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function log($action, $description, $user_id = null, $icon = 'fas fa-info-circle') {
        $sql = "INSERT INTO activity_logs (user_id, action, description, icon) VALUES (?, ?, ?, ?)";
        $this->db->query($sql, [$user_id, $action, $description, $icon]);
    }
} 