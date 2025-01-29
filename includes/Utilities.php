<?php
class Utilities {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getPagination($table, $perPage = 10) {
        $sql = "SELECT COUNT(*) as total FROM $table";
        $result = $this->db->query($sql, [], 'result');
        $row = $result->fetch_assoc();
        return ceil($row['total'] / $perPage);
    }

    public function exportToCSV($data, $filename) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
    }

    public function generatePasswordResetToken($email) {
        $token = bin2hex(random_bytes(32));
        $sql = "UPDATE admin_users SET reset_token = ?, reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) 
                WHERE email = ?";
        return $this->db->query($sql, [$token, $email]);
    }
} 