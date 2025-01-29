<?php
class Database {
    private $conn;
    
    public function __construct() {
        if (!defined('DB_HOST')) {
            require_once 'config.php';
        }
        
        try {
            $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
            
            // Set charset for special characters
            $this->conn->set_charset("utf8mb4");
            
        } catch (Exception $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            throw new Exception("Database connection failed");
        }
    }
    
    public function query($sql, $params = [], $returnType = 'result') {
        try {
            $stmt = $this->conn->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->conn->error);
            }
            
            if ($params) {
                $types = str_repeat('s', count($params));
                $stmt->bind_param($types, ...$params);
            }
            
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            
            $result = $stmt->get_result();
            return $returnType === 'array' ? $result->fetch_all(MYSQLI_ASSOC) : $result;
            
        } catch (Exception $e) {
            error_log("Query Error: " . $e->getMessage());
            throw new Exception("Query execution failed: " . $e->getMessage());
        }
    }

    public function escape($value) {
        return $this->conn->real_escape_string($value);
    }

    public function lastInsertId() {
        return $this->conn->insert_id;
    }
} 