<?php 
$isHomePage = false;
include '../components/pages_header.php'; 
?>

<main class="courses-page">
    <?php include '../components/navigation.php'; ?>
    
    <section class="page-header">
        <h1><i class="fas fa-graduation-cap"></i> Our Courses</h1>
        <p>Explore our comprehensive tech training programs</p>
    </section>

    <section class="courses-grid">
        <div class="course-card">
            <div class="course-image">
                <img src="../images/web-dev.jpg" alt="Web Development">
            </div>
            <div class="course-content">
                <h3>Web Development</h3>
                <p>Master modern web technologies and frameworks</p>
                <ul>
                    <li>HTML5, CSS3, JavaScript</li>
                    <li>React.js & Node.js</li>
                    <li>Database Management</li>
                </ul>
                <a href="register.php" class="course-btn">Enroll Now</a>
            </div>
        </div>

        <div class="course-card">
            <div class="course-image">
                <img src="../images/cloud-computing.jpg" alt="Cloud Computing">
            </div>
            <div class="course-content">
                <h3>Cloud Computing</h3>
                <p>Learn cloud platforms and deployment</p>
                <ul>
                    <li>AWS & Azure</li>
                    <li>Cloud Architecture</li>
                    <li>DevOps Practices</li>
                </ul>
                <a href="register.php" class="course-btn">Enroll Now</a>
            </div>
        </div>

        <div class="course-card">
            <div class="course-image">
                <img src="../images/data-science.jpg" alt="Data Science">
            </div>
            <div class="course-content">
                <h3>Data Science</h3>
                <p>Explore data analysis and machine learning</p>
                <ul>
                    <li>Python for Data Science</li>
                    <li>Machine Learning</li>
                    <li>Data Visualization</li>
                </ul>
                <a href="register.php" class="course-btn">Enroll Now</a>
            </div>
        </div>

        <div class="course-card">
            <div class="course-image">
                <img src="../images/cybersecurity.jpg" alt="Cybersecurity">
            </div>
            <div class="course-content">
                <h3>Cybersecurity</h3>
                <p>Learn to protect systems and networks</p>
                <ul>
                    <li>Network Security</li>
                    <li>Ethical Hacking</li>
                    <li>Security Compliance</li>
                </ul>
                <a href="register.php" class="course-btn">Enroll Now</a>
            </div>
        </div>
    </section>
</main>

<?php include '../components/footer.php'; ?> 