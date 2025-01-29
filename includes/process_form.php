<?php
require_once 'Database.php';
require_once 'Utilities.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $db = new Database();
        
        // Validate inputs
        if (empty($_POST['fullname']) || empty($_POST['email']) || empty($_POST['phone'])) {
            throw new Exception('Please fill in all required fields.');
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Please enter a valid email address.');
        }

        // Process the registration
        // ... your existing registration logic ...

        echo json_encode([
            'status' => 'success',
            'message' => 'Registration successful!'
        ]);

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
}
?> 