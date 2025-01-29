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

try {
    $db = new Database();
    $sql = "SELECT * FROM students ORDER BY created_at DESC";
    $students = $db->query($sql, [], 'array');
} catch (Exception $e) {
    error_log($e->getMessage());
    $error = "An error occurred while loading students.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - Tech Training</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Include all the base styles from dashboard */
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

        /* Sidebar Styles (same as dashboard) */
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

        .nav-links a:hover, .nav-links a.active {
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

        /* Students Table Specific Styles */
        .students-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .page-title {
            font-size: 1.5rem;
            color: #2D3250;
        }

        .add-student-btn {
            background: #2D3250;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .add-student-btn:hover {
            background: #424769;
            transform: translateY(-2px);
        }

        .students-table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .students-table {
            width: 100%;
            border-collapse: collapse;
        }

        .students-table th,
        .students-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .students-table th {
            background: #f8f9fa;
            color: #2D3250;
            font-weight: 600;
        }

        .students-table tr:hover {
            background: #f8f9fa;
        }

        .student-actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-icon {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .view-btn {
            background: #3498db;
        }

        .edit-btn {
            background: #2ecc71;
        }

        .delete-btn {
            background: #e74c3c;
        }

        .action-icon:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-active {
            background: #e1f6e1;
            color: #2ecc71;
        }

        .status-inactive {
            background: #fee7e7;
            color: #e74c3c;
        }

        /* Search and Filter Section */
        .filter-section {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .search-box {
            flex: 1;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .filter-dropdown {
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
            color: #2D3250;
            cursor: pointer;
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
                <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="students.php" class="active"><i class="fas fa-user-graduate"></i> Students</a></li>
                <li><a href="courses.php"><i class="fas fa-book"></i> Courses</a></li>
                <li><a href="webinar.php"><i class="fas fa-video"></i> Webinars</a></li>
                <li><a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="students-header">
                <h1 class="page-title">Manage Students</h1>
                <a href="add-student.php" class="add-student-btn">
                    <i class="fas fa-plus"></i>
                    Add New Student
                </a>
            </div>

            <!-- Search and Filter Section -->
            <div class="filter-section">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search students...">
                </div>
                <select class="filter-dropdown">
                    <option value="">All Students</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="students-table-container">
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Education</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                            <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($student['email']); ?></td>
                            <td><?php echo htmlspecialchars($student['phone']); ?></td>
                            <td><?php echo htmlspecialchars($student['education_level']); ?></td>
                            <td>
                                <span class="status-badge status-active">Active</span>
                            </td>
                            <td>
                                <div class="student-actions">
                                    <a href="view-student.php?id=<?php echo $student['student_id']; ?>" class="action-icon view-btn">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="edit-student.php?id=<?php echo $student['student_id']; ?>" class="action-icon edit-btn">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete-student.php?id=<?php echo $student['student_id']; ?>" class="action-icon delete-btn" onclick="return confirm('Are you sure you want to delete this student?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html> 