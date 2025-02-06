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

// For debugging - store results in variables instead of echoing directly
$debug_result = '';
$debug_registrations = '';

try {
    $db = new Database();
    
    // Get all registrations
    $registrations = [];
    $result = $db->query("SELECT * FROM webinar_registrations ORDER BY registration_date DESC");
    
    // Store debug info in variables instead of echoing
    ob_start();
    print_r($result);
    $debug_result = ob_get_clean();
    
    while ($row = $result->fetch_assoc()) {
        $registrations[] = $row;
    }
    
    // Store registrations debug info
    ob_start();
    print_r($registrations);
    $debug_registrations = ob_get_clean();
    
    // Get today's registrations count
    $today_result = $db->query("SELECT COUNT(*) as today_count 
            FROM webinar_registrations 
            WHERE DATE(registration_date) = CURDATE()");
    $today_registrations = $today_result->fetch_assoc();
    
    // Get this month's registrations count
    $month_result = $db->query("SELECT COUNT(*) as month_count 
            FROM webinar_registrations 
            WHERE MONTH(registration_date) = MONTH(CURRENT_DATE())
            AND YEAR(registration_date) = YEAR(CURRENT_DATE())");
    $month_registrations = $month_result->fetch_assoc();
    
    // Calculate attendance rate
    $attendance_result = $db->query("SELECT 
            COUNT(CASE WHEN attended = 1 THEN 1 END) * 100.0 / NULLIF(COUNT(*), 0) as attendance_rate
            FROM webinar_registrations");
    $attendance = $attendance_result->fetch_assoc();
    
} catch (Exception $e) {
    error_log($e->getMessage());
    $error = "An error occurred while loading webinar registrations.";
}

// Search functionality
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM webinar_registrations 
            WHERE fullname LIKE ? 
            OR email LIKE ? 
            OR phone LIKE ? 
            OR occupation LIKE ?
            ORDER BY registration_date DESC";
    $params = ["%$search%", "%$search%", "%$search%", "%$search%"];
    $registrations = $db->query($sql, $params, 'array');
}

// Filter functionality
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
    switch($filter) {
        case 'today':
            $sql = "SELECT * FROM webinar_registrations 
                    WHERE DATE(registration_date) = CURDATE()
                    ORDER BY registration_date DESC";
            break;
        case 'week':
            $sql = "SELECT * FROM webinar_registrations 
                    WHERE registration_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                    ORDER BY registration_date DESC";
            break;
        case 'month':
            $sql = "SELECT * FROM webinar_registrations 
                    WHERE MONTH(registration_date) = MONTH(CURRENT_DATE())
                    AND YEAR(registration_date) = YEAR(CURRENT_DATE())
                    ORDER BY registration_date DESC";
            break;
    }
    $registrations = $db->query($sql, [], 'array');
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webinar Management - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .webinar-controls {
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

        .webinar-table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .webinar-table {
            width: 100%;
            border-collapse: collapse;
        }

        .webinar-table th {
            background: #f8f9fa;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #2D3250;
            border-bottom: 2px solid #eee;
        }

        .webinar-table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            color: #666;
        }

        .webinar-table tr:hover {
            background: #f8f9fa;
        }

        .registration-date {
            color: #6c757d;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-registered {
            background: #e1f6e1;
            color: #2ecc71;
        }

        .status-pending {
            background: #fff3cd;
            color: #ffc107;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.5rem;
            border-radius: 8px;
            color: #666;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: #f8f9fa;
            color: #2D3250;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
            font-size: 2rem;
            font-weight: 600;
            color: #2D3250;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <?php include 'includes/sidebar.php'; ?>

        <div class="main-content">
            <!-- Add debug information in a collapsible section -->
            <?php if (!empty($debug_result) || !empty($debug_registrations)): ?>
            <div class="debug-section" style="margin-bottom: 20px; padding: 10px; background: #f8f9fa; border-radius: 8px;">
                <details>
                    <summary style="cursor: pointer; padding: 10px;">Debug Information</summary>
                    <div style="padding: 10px; background: white; margin-top: 10px; border-radius: 4px;">
                        <h4>Database Result:</h4>
                        <pre><?php echo htmlspecialchars($debug_result); ?></pre>
                        
                        <h4>Registrations Array:</h4>
                        <pre><?php echo htmlspecialchars($debug_registrations); ?></pre>
                    </div>
                </details>
            </div>
            <?php endif; ?>

            <div class="page-header">
                <h1>Webinar Registrations</h1>
                <button class="btn btn-primary" onclick="window.location.href='export-webinars.php'">
                    <i class="fas fa-download"></i> Export Data
                </button>
            </div>

            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-value">
                        <?php echo count($registrations); ?>
                    </div>
                    <div class="stat-label">Total Registrations</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">
                        <?php echo $today_registrations['today_count']; ?>
                    </div>
                    <div class="stat-label">Today's Registrations</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">
                        <?php echo $month_registrations['month_count']; ?>
                    </div>
                    <div class="stat-label">This Month</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">
                        <?php echo number_format($attendance['attendance_rate'] ?? 0, 1); ?>%
                    </div>
                    <div class="stat-label">Attendance Rate</div>
                </div>
            </div>

            <div class="webinar-controls">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search registrations...">
                </div>
                <select class="filter-dropdown">
                    <option value="">All Registrations</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
            </div>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="webinar-table-container">
                <?php if (empty($registrations)): ?>
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list"></i>
                        <h3>No registrations yet</h3>
                        <p>Webinar registrations will appear here</p>
                    </div>
                <?php else: ?>
                    <table class="webinar-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Occupation</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registrations as $registration): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($registration['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($registration['email']); ?></td>
                                <td><?php echo htmlspecialchars($registration['phone']); ?></td>
                                <td><?php echo htmlspecialchars($registration['occupation']); ?></td>
                                <td>
                                    <div class="registration-date">
                                        <i class="far fa-calendar"></i>
                                        <?php echo date('M d, Y', strtotime($registration['registration_date'])); ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-registered">Registered</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="view-registration.php?id=<?php echo $registration['id']; ?>" 
                                           class="action-btn" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="mailto:<?php echo $registration['email']; ?>" 
                                           class="action-btn" title="Send Email">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                        <a href="delete-registration.php?id=<?php echo $registration['id']; ?>" 
                                           class="action-btn" 
                                           onclick="return confirm('Are you sure you want to delete this registration?')"
                                           title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>


</body>
</html> 