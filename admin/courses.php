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
    $sql = "SELECT * FROM courses ORDER BY created_at DESC";
    $courses = $db->query($sql, [], 'array');
} catch (Exception $e) {
    error_log($e->getMessage());
    $error = "An error occurred while loading courses.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses - Tech Training</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .course-controls {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            align-items: center;
        }

        .search-box {
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: none;
            border-radius: 12px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            font-size: 1rem;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .filter-dropdown {
            padding: 1rem;
            border: none;
            border-radius: 12px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            color: #2D3250;
            font-size: 1rem;
            cursor: pointer;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .course-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-5px);
        }

        .course-header {
            background: #2D3250;
            color: white;
            padding: 1.5rem;
            position: relative;
            height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .course-header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .course-status {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
        }

        .course-price {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .course-body {
            padding: 1.5rem;
        }

        .course-title {
            font-size: 1.3rem;
            color: #2D3250;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .course-stats {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
            margin-bottom: 1rem;
            color: #666;
            font-size: 0.9rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .course-description {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            min-height: 60px;
        }

        .course-actions {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 0.8rem;
        }

        .btn-edit {
            background: #2D3250;
            color: white;
            padding: 0.8rem;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            transition: background 0.3s ease;
        }

        .btn-edit:hover {
            background: #424769;
        }

        .btn-delete {
            background: #fff0f0;
            color: #dc3545;
            padding: 0.8rem;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-delete:hover {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <?php include 'includes/sidebar.php'; ?>

        <div class="main-content">
            <div class="page-header">
                <h1>Manage Courses</h1>
                <a href="add-course.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add New Course
                </a>
            </div>

            <div class="course-controls">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search courses...">
                </div>
                <select class="filter-dropdown">
                    <option value="">All Courses</option>
                    <option value="active">Active</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="archived">Archived</option>
                </select>
            </div>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="courses-grid">
                <?php foreach ($courses as $course): ?>
                <div class="course-card">
                    <div class="course-header">
                        <div class="course-header-top">
                            <span class="course-status">Active</span>
                            <span class="course-price">₹<?php echo number_format($course['price']); ?></span>
                        </div>
                        <h3 class="course-name"><?php echo htmlspecialchars($course['course_name']); ?></h3>
                    </div>
                    
                    <div class="course-body">
                        <div class="course-stats">
                            <div class="stat-item">
                                <i class="fas fa-clock"></i>
                                <?php echo htmlspecialchars($course['duration']); ?>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-users"></i>
                                25 Students
                            </div>
                        </div>

                        <p class="course-description">
                            <?php echo htmlspecialchars($course['description']); ?>
                        </p>

                        <div class="course-actions">
                            <a href="edit-course.php?id=<?php echo $course['course_id']; ?>" class="btn-edit">
                                Edit Course
                            </a>
                            <a href="delete-course.php?id=<?php echo $course['course_id']; ?>" 
                               class="btn-delete"
                               onclick="return confirm('Are you sure you want to delete this course?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html> 