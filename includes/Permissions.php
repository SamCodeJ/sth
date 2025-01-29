<?php
class Permissions {
    private $db;
    private $user_role;

    public function __construct($user_role) {
        $this->db = new Database();
        $this->user_role = $user_role;
    }

    public function can($permission) {
        $sql = "SELECT COUNT(*) as count FROM role_permissions rp 
                JOIN permissions p ON rp.permission_id = p.permission_id 
                WHERE rp.role = ? AND p.name = ?";
        
        $result = $this->db->query($sql, [$this->user_role, $permission]);
        return $result[0]['count'] > 0;
    }
} 