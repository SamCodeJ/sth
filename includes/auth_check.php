<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkAuth() {
    // Check if user is logged in
    if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
        // Store the requested URL for redirect after login
        $_SESSION['redirect_url'] = $_SERVER['PHP_SELF'];
        header('Location: login.php');
        exit;
    }
    return true;
}

function getLoggedInUser() {
    if (isset($_SESSION['admin_id'])) {
        $db = new Database();
        $sql = "SELECT admin_id, username, full_name, email, role FROM admin_users WHERE admin_id = ?";
        $result = $db->query($sql, [$_SESSION['admin_id']], 'result');
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    }
    return null;
}

// Add this function to check if user is already logged in
function isLoggedIn() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
} 