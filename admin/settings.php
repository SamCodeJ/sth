<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once('../includes/Database.php');
require_once('../includes/config.php');

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Database();
        
        if (isset($_POST['update_profile'])) {
            // Update admin profile
            $username = trim($_POST['username']);
            $full_name = trim($_POST['full_name']);
            $email = trim($_POST['email']);
            
            $sql = "UPDATE admin_users SET 
                    username = ?, 
                    full_name = ?, 
                    email = ? 
                    WHERE admin_id = ?";
            
            $db->query($sql, [$username, $full_name, $email, $_SESSION['admin_id']]);
            $success_message = "Profile updated successfully!";
        }
        
        if (isset($_POST['change_password'])) {
            // Change password
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            
            if ($new_password !== $confirm_password) {
                throw new Exception("New passwords do not match!");
            }
            
            // Verify current password - fixed the query result handling
            $stmt = $db->query(
                "SELECT password FROM admin_users WHERE admin_id = ?", 
                [$_SESSION['admin_id']]
            );
            $result = $stmt->fetch_assoc();
            
            if (!$result || !password_verify($current_password, $result['password'])) {
                throw new Exception("Current password is incorrect!");
            }
            
            // Update password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $db->query(
                "UPDATE admin_users SET password = ? WHERE admin_id = ?",
                [$hashed_password, $_SESSION['admin_id']]
            );
            
            $success_message = "Password changed successfully!";
        }
        
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Get current admin data
try {
    $db = new Database();
    
    // Get current admin data using correct column names
    $stmt = $db->query(
        "SELECT username, full_name, email FROM admin_users WHERE admin_id = ?",
        [$_SESSION['admin_id']]
    );
    
    // Fetch the result as an associative array
    $admin = $stmt->fetch_assoc();
    
    if (!$admin) {
        throw new Exception("Admin not found with ID: " . $_SESSION['admin_id']);
    }
    
} catch (Exception $e) {
    error_log($e->getMessage());
    $error_message = "Failed to load admin data. Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Tech Training</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .settings-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .settings-card h2 {
            color: #2D3250;
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2D3250;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .btn-submit {
            background: #2D3250;
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background: #424769;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <?php include 'includes/sidebar.php'; ?>

        <div class="main-content">
            <div class="page-header">
                <h1>Settings</h1>
            </div>

            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <div class="settings-grid">
                <div class="settings-card">
                    <h2>Profile Settings</h2>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" 
                                   value="<?php echo htmlspecialchars($admin['username'] ?? ''); ?>" 
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" id="full_name" name="full_name" 
                                   value="<?php echo htmlspecialchars($admin['full_name'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($admin['email'] ?? ''); ?>">
                        </div>
                        <button type="submit" name="update_profile" class="btn-submit">
                            Update Profile
                        </button>
                    </form>
                </div>

                <div class="settings-card">
                    <h2>Change Password</h2>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" name="change_password" class="btn-submit">
                            Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add password validation
        document.querySelector('form[name="change_password"]').addEventListener('submit', function(e) {
            const newPass = document.getElementById('new_password').value;
            const confirmPass = document.getElementById('confirm_password').value;
            
            if (newPass !== confirmPass) {
                e.preventDefault();
                alert('New passwords do not match!');
            }
        });
    </script>
</body>
</html> 