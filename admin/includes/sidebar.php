<div class="sidebar">
    <div class="logo">
        <h2>Tech Training</h2>
    </div>
    <nav>
        <ul>
            <li><a href="dashboard.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'class="active"' : ''; ?>>
                <i class="fas fa-home"></i> Dashboard
            </a></li>
            
            <li><a href="courses.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'courses.php') ? 'class="active"' : ''; ?>>
                <i class="fas fa-book"></i> Courses
            </a></li>
            
            <li><a href="students.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'students.php') ? 'class="active"' : ''; ?>>
                <i class="fas fa-users"></i> Students
            </a></li>
            
            <li><a href="reports.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'reports.php') ? 'class="active"' : ''; ?>>
                <i class="fas fa-chart-bar"></i> Reports
            </a></li>
            
            <li><a href="settings.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'settings.php') ? 'class="active"' : ''; ?>>
                <i class="fas fa-cog"></i> Settings
            </a></li>
        </ul>
        
        <div class="logout-container">
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>
</div>

<style>
.sidebar {
    width: 250px;
    height: 100vh;
    background: #2C3E50;
    color: #fff;
    position: fixed;
    left: 0;
    top: 0;
    overflow-y: auto;
}

.logo {
    padding: 20px;
    text-align: center;
    background: #243342;
    margin-bottom: 20px;
}

.logo h2 {
    margin: 0;
    font-size: 24px;
    color: #fff;
}

nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

nav ul li {
    margin: 0;
    padding: 0;
}

nav ul li a {
    display: flex;
    align-items: center;
    padding: 15px 25px;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 16px;
}

nav ul li a:hover {
    background: #34495E;
    padding-left: 30px;
}

nav ul li a.active {
    background: #34495E;
    border-left: 4px solid #3498DB;
}

nav ul li a i {
    margin-right: 10px;
    width: 20px;
    text-align: center;
}

.logout-container {
    margin-top: auto;
    padding: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    position: fixed;
    bottom: 0;
    width: 250px;
    background: #2C3E50;
}

.logout-btn {
    display: flex;
    align-items: center;
    padding: 12px 25px;
    color: #ff6b6b;
    text-decoration: none;
    transition: all 0.3s ease;
    border-radius: 5px;
}

.logout-btn:hover {
    background: rgba(255, 107, 107, 0.1);
    color: #ff4757;
}

.logout-btn i {
    margin-right: 10px;
}

/* Ensure main content doesn't overlap with sidebar */
.main-content {
    margin-left: 250px;
    padding: 20px;
    min-height: 100vh;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .sidebar {
        width: 200px;
    }
    
    .logout-container {
        width: 200px;
    }
    
    .main-content {
        margin-left: 200px;
    }
}
</style> 