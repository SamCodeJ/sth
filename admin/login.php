<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../includes/Database.php');
require_once('../includes/config.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// DO NOT include auth_check.php here
// DO NOT check for isLoggedIn() here as it creates a redirect loop

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Database();
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Debug line - remove in production
        error_log("Login attempt - Username: " . $username);

        $sql = "SELECT * FROM admin_users WHERE username = ?";
        $result = $db->query($sql, [$username], 'result');
        
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['admin_id'] = $user['admin_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                header('Location: dashboard.php');
                exit;
            }
        }
        $error = "Invalid username or password";
    } catch (Exception $e) {
        error_log($e->getMessage());
        $error = "An error occurred. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #2D3250, #424769);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h2 {
            color: #2D3250;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #676F9D;
            font-size: 0.9rem;
        }

        .error-message {
            background: #ffe6e6;
            color: #dc3545;
            padding: 0.8rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .error-message i {
            margin-right: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #676F9D;
        }

        input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 2px solid #e1e5ee;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #424769;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background: #424769;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #2D3250;
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            color: #676F9D;
            font-size: 0.9rem;
        }

        .footer-text a {
            color: #424769;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Admin Login</h2>
            <p>Enter your credentials to access the dashboard</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="login-form">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" required placeholder="Username">
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" required placeholder="Password">
            </div>
            <button type="submit">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="footer-text">
            <p>Forgot your password? <a href="#">Reset here</a></p>
        </div>
    </div>
</body>
</html>