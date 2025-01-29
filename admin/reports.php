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

// Initialize arrays to prevent undefined variable errors
$recent_enrollments = [];
$revenue_trend = [];
$course_popularity = [];
$total_revenue = 0;
$active_students = 0;
$active_courses = 0;
$completion_rate = 0;

try {
    $db = new Database();
    
    // Get recent enrollments with the correct column name 'full_name'
    $result = $db->query("
        SELECT 
            s.full_name as student_name,
            c.course_name,
            ce.created_at,
            ce.price,
            ce.status
        FROM course_enrollments ce
        JOIN students s ON ce.student_id = s.student_id
        JOIN courses c ON ce.course_id = c.course_id
        ORDER BY ce.created_at DESC
        LIMIT 10
    ");

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $recent_enrollments[] = $row;
        }
    }

    // Get total revenue with error checking
    $revenue_result = $db->query("
        SELECT COALESCE(SUM(price), 0) as total_revenue 
        FROM course_enrollments 
        WHERE status != 'cancelled'
    ");
    
    if ($revenue_result) {
        $total_revenue = $revenue_result->fetch_assoc()['total_revenue'];
    }

    // Get active students count with error checking
    $students_result = $db->query("
        SELECT COUNT(DISTINCT student_id) as active_students 
        FROM course_enrollments 
        WHERE status = 'active'
    ");
    
    if ($students_result) {
        $active_students = $students_result->fetch_assoc()['active_students'];
    }

    // Get active courses count with error checking
    $courses_result = $db->query("
        SELECT COUNT(*) as active_courses 
        FROM courses 
        WHERE status = 'active'
    ");
    
    if ($courses_result) {
        $active_courses = $courses_result->fetch_assoc()['active_courses'];
    }

    // Get completion rate
    $completion_result = $db->query("
        SELECT 
            (COUNT(CASE WHEN status = 'completed' THEN 1 END) * 100.0 / 
             COUNT(*)) as completion_rate
        FROM course_enrollments
        WHERE status != 'cancelled'
    ");
    $completion_rate = round($completion_result->fetch_assoc()['completion_rate'] ?? 0, 1);
    
    // Get monthly revenue trend
    $revenue_trend = $db->query("
        SELECT 
            DATE_FORMAT(created_at, '%b') as month,
            SUM(price) as revenue
        FROM course_enrollments
        WHERE 
            status != 'cancelled' AND
            created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
        GROUP BY DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY created_at DESC
    ")->fetch_all(MYSQLI_ASSOC);
    
    // Get course popularity
    $course_popularity = $db->query("
        SELECT 
            c.course_name,
            COUNT(ce.id) as enrollment_count
        FROM courses c
        LEFT JOIN course_enrollments ce ON c.course_id = ce.course_id
        WHERE ce.status != 'cancelled'
        GROUP BY c.course_id
        ORDER BY enrollment_count DESC
        LIMIT 5
    ")->fetch_all(MYSQLI_ASSOC);
    
} catch (Exception $e) {
    error_log($e->getMessage());
    $error = "An error occurred while loading report data: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Tech Training</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .report-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .report-card h3 {
            color: #2D3250;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 600;
            color: #2D3250;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin-top: 1rem;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .data-table th,
        .data-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .data-table th {
            background: #f8f9fa;
            color: #2D3250;
            font-weight: 600;
        }

        .report-filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .date-filter {
            padding: 0.8rem;
            border: 1px solid #eee;
            border-radius: 8px;
            color: #2D3250;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <?php include 'includes/sidebar.php'; ?>

        <div class="main-content">
            <div class="page-header">
                <h1>Reports & Analytics</h1>
                <div class="report-filters">
                    <select class="date-filter">
                        <option value="7">Last 7 days</option>
                        <option value="30">Last 30 days</option>
                        <option value="90">Last 90 days</option>
                        <option value="365">Last year</option>
                    </select>
                    <button class="btn btn-primary">
                        <i class="fas fa-download"></i>
                        Export Report
                    </button>
                </div>
            </div>

            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-value">₹<?php echo number_format($total_revenue); ?></div>
                    <div class="stat-label">Total Revenue</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $active_students; ?></div>
                    <div class="stat-label">Active Students</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $active_courses; ?></div>
                    <div class="stat-label">Active Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $completion_rate; ?>%</div>
                    <div class="stat-label">Completion Rate</div>
                </div>
            </div>

            <div class="reports-grid">
                <div class="report-card">
                    <h3>Revenue Trend</h3>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
                <div class="report-card">
                    <h3>Popular Courses</h3>
                    <div class="chart-container">
                        <canvas id="coursesChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="report-card">
                <h3>Recent Enrollments</h3>
                <?php if (!empty($error)): ?>
                    <div class="error-message">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php elseif (empty($recent_enrollments)): ?>
                    <div class="empty-state">
                        <i class="fas fa-info-circle"></i>
                        <p>No recent enrollments found</p>
                    </div>
                <?php else: ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_enrollments as $enrollment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($enrollment['student_name'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($enrollment['course_name'] ?? ''); ?></td>
                                <td><?php echo isset($enrollment['created_at']) ? date('Y-m-d', strtotime($enrollment['created_at'])) : ''; ?></td>
                                <td>₹<?php echo number_format($enrollment['price'] ?? 0); ?></td>
                                <td><?php echo ucfirst($enrollment['status'] ?? ''); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Revenue Chart
        const revenueData = <?php echo json_encode(array_column($revenue_trend, 'revenue')); ?>;
        const revenueLabels = <?php echo json_encode(array_column($revenue_trend, 'month')); ?>;

        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Revenue',
                    data: revenueData,
                    borderColor: '#2D3250',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Courses Chart
        const courseLabels = <?php echo json_encode(array_column($course_popularity, 'course_name')); ?>;
        const courseData = <?php echo json_encode(array_column($course_popularity, 'enrollment_count')); ?>;

        const coursesCtx = document.getElementById('coursesChart').getContext('2d');
        new Chart(coursesCtx, {
            type: 'doughnut',
            data: {
                labels: courseLabels,
                datasets: [{
                    data: courseData,
                    backgroundColor: [
                        '#2D3250',
                        '#424769',
                        '#676F9D',
                        '#9BA3EB',
                        '#C7D3FF'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html> 