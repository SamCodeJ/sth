<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Basic session check before including other files
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once('../includes/Database.php');
require_once('../includes/config.php');
require_once('../includes/ErrorHandler.php');

try {
    $db = new Database();
    
    // Get user details
    $sql = "SELECT * FROM admin_users WHERE admin_id = ?";
    $result = $db->query($sql, [$_SESSION['admin_id']], 'result');
    $user = $result->fetch_assoc();
    
    // Get dashboard statistics
    $stats = [
        'total_students' => $db->query("SELECT COUNT(*) as count FROM students", [], 'result')->fetch_assoc()['count'],
        'total_webinar' => $db->query("SELECT COUNT(*) as count FROM webinar_registrations", [], 'result')->fetch_assoc()['count'],
        'recent_registrations' => $db->query("SELECT COUNT(*) as count FROM registrations WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)", [], 'result')->fetch_assoc()['count']
    ];
} catch (Exception $e) {
    error_log($e->getMessage());
    $error = "An error occurred while loading the dashboard.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tech Training</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f5f6fa;
            color: #2c3e50;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            background: #2D3250;
            color: white;
            padding: 2rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nav-links {
            list-style: none;
        }

        .nav-links li {
            margin-bottom: 1rem;
        }

        .nav-links a {
            color: #a4b0be;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .nav-links i {
            margin-right: 10px;
            width: 20px;
        }

        /* Main Content Styles */
        .main-content {
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .welcome-text h1 {
            font-size: 1.8rem;
            color: #2D3250;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #424769;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: #f0f2f7;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #424769;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #2D3250;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-btn {
            background: white;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #2D3250;
            font-weight: 500;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: #2D3250;
            color: white;
            transform: translateY(-2px);
        }

        .action-btn.logout {
            background: #dc3545;
            color: white;
        }

        .action-btn.logout:hover {
            background: #c82333;
        }

        .error-message {
            background: #ffe6e6;
            color: #dc3545;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                Tech Training
            </div>
            <ul class="nav-links">
                <li><a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="students.php"><i class="fas fa-user-graduate"></i> Students</a></li>
                <li><a href="courses.php"><i class="fas fa-book"></i> Courses</a></li>
                <li><a href="webinar.php"><i class="fas fa-video"></i> Webinars</a></li>
                <li><a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="welcome-text">
                    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $stats['total_students']; ?></div>
                    <div class="stat-label">Total Students</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-video"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $stats['total_webinar']; ?></div>
                    <div class="stat-label">Webinar Registrations</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo $stats['recent_registrations']; ?></div>
                    <div class="stat-label">Recent Registrations</div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="students.php" class="action-btn">
                    <i class="fas fa-user-graduate"></i>
                    Manage Students
                </a>
                <a href="courses.php" class="action-btn">
                    <i class="fas fa-book"></i>
                    Manage Courses
                </a>
                <a href="webinar.php" class="action-btn">
                    <i class="fas fa-video"></i>
                    Webinar Registrations
                </a>
                <a href="logout.php" class="action-btn logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </div>
    </div>
</body>
</html> 