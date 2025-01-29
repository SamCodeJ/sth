<?php
require_once 'Database.php';
require_once 'Utilities.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database();
    
    // Collect form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $occupation = $_POST['occupation'];
    $source = $_POST['source'];
    $questions = $_POST['questions'];

    // SQL query
    $sql = "INSERT INTO webinar_registrations (fullname, email, phone, country, occupation, source, questions) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    try {
        $stmt = $db->query($sql, [
            $fullname,
            $email,
            $phone,
            $country,
            $occupation,
            $source,
            $questions
        ]);

        // Send success response
        echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
    } catch (Exception $e) {
        // Send error response
        echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
    }
}
?> 