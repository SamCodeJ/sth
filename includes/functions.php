<?php
require_once('Database.php');

class Operations {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Student Operations
    public function registerStudent($data) {
        $sql = "INSERT INTO students (full_name, email, phone, address, date_of_birth, 
                gender, education_level) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        return $this->db->query($sql, [
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $data['date_of_birth'],
            $data['gender'],
            $data['education_level']
        ]);
    }

    public function createRegistration($studentId, $courseId, $paymentMethod) {
        $sql = "INSERT INTO registrations (student_id, course_id, payment_method) 
                VALUES (?, ?, ?)";
        
        return $this->db->query($sql, [$studentId, $courseId, $paymentMethod]);
    }

    // Admin Operations
    public function getRegistrations($limit = 10, $offset = 0) {
        $sql = "SELECT r.*, s.full_name, s.email, s.phone, c.course_name 
                FROM registrations r 
                JOIN students s ON r.student_id = s.student_id 
                JOIN courses c ON r.course_id = c.course_id 
                ORDER BY r.registration_date DESC 
                LIMIT ? OFFSET ?";
        
        return $this->db->query($sql, [$limit, $offset]);
    }

    public function searchStudents($search) {
        $sql = "SELECT * FROM students 
                WHERE full_name LIKE ? OR email LIKE ? OR phone LIKE ?";
        $searchTerm = "%{$search}%";
        
        return $this->db->query($sql, [$searchTerm, $searchTerm, $searchTerm]);
    }

    // Payment Operations
    public function recordPayment($registrationId, $amount, $method) {
        $sql = "INSERT INTO payments (registration_id, amount, payment_method) 
                VALUES (?, ?, ?)";
        
        $result = $this->db->query($sql, [$registrationId, $amount, $method]);
        
        if($result) {
            $this->updateRegistrationPayment($registrationId);
        }
        
        return $result;
    }

    private function updateRegistrationPayment($registrationId) {
        $sql = "UPDATE registrations r 
                SET payment_status = 
                    CASE 
                        WHEN (SELECT SUM(amount) FROM payments 
                              WHERE registration_id = ?) >= 
                             (SELECT price FROM courses c 
                              JOIN registrations reg ON c.course_id = reg.course_id 
                              WHERE reg.registration_id = ?) 
                        THEN 'completed' 
                        ELSE 'partial' 
                    END 
                WHERE registration_id = ?";
        
        return $this->db->query($sql, [$registrationId, $registrationId, $registrationId]);
    }

    // Security: Activity Logging
    public function logActivity($adminId, $action, $description) {
        $sql = "INSERT INTO activity_logs (admin_id, action, description, ip_address) 
                VALUES (?, ?, ?, ?)";
        
        return $this->db->query($sql, [
            $adminId,
            $action,
            $description,
            $_SERVER['REMOTE_ADDR']
        ]);
    }
} 