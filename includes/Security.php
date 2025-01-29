<?php
class Security {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function createSession($adminId) {
        $sessionId = bin2hex(random_bytes(32));
        $sql = "INSERT INTO sessions (session_id, admin_id, ip_address, user_agent) 
                VALUES (?, ?, ?, ?)";
        
        $this->db->query($sql, [
            $sessionId,
            $adminId,
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_USER_AGENT']
        ]);

        return $sessionId;
    }

    public function validateSession($sessionId) {
        $sql = "SELECT s.*, a.status FROM sessions s 
                JOIN admin_users a ON s.admin_id = a.admin_id 
                WHERE s.session_id = ? AND a.status = 'active' 
                AND s.last_activity > DATE_SUB(NOW(), INTERVAL 24 HOUR)";
        
        $result = $this->db->query($sql, [$sessionId], 'result');
        return $result->num_rows > 0;
    }

    public function updateSessionActivity($sessionId) {
        $sql = "UPDATE sessions SET last_activity = NOW() WHERE session_id = ?";
        return $this->db->query($sql, [$sessionId]);
    }

    public function clearOldSessions() {
        $sql = "DELETE FROM sessions WHERE last_activity < DATE_SUB(NOW(), INTERVAL 24 HOUR)";
        return $this->db->query($sql);
    }
} 