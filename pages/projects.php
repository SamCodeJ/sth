<?php 
$isHomePage = false;
include '../components/pages_header.php'; 
?>

<main class="projects-page">
    <?php include '../components/navigation.php'; ?>
    
    <section class="page-header">
        <h1><i class="fas fa-project-diagram"></i> Our Projects</h1>
        <p>Explore real-world projects developed by our students</p>
    </section>

    <section class="projects-grid">
        <div class="project-card">
            <div class="project-image">
                <img src="../images/project1.jpg" alt="E-Commerce Platform">
            </div>
            <div class="project-content">
                <h3>E-Commerce Platform</h3>
                <p>A full-stack e-commerce solution with modern features</p>
                <div class="tech-stack">
                    <span>React</span>
                    <span>Node.js</span>
                    <span>MongoDB</span>
                </div>
                <div class="project-links">
                    <a href="#" class="project-btn"><i class="fas fa-eye"></i> View Demo</a>
                    <a href="#" class="project-btn"><i class="fab fa-github"></i> Source Code</a>
                </div>
            </div>
        </div>

        <div class="project-card">
            <div class="project-image">
                <img src="../images/project2.jpg" alt="Cloud Management Dashboard">
            </div>
            <div class="project-content">
                <h3>Learning Management System</h3>
                <p>A resource management system for learning</p>
                <div class="tech-stack">
                    <span>PHP</span>
                    <span>Bootstrap</span>
                    <span>JavaScript</span>
                    <span>MySQL</span>
                </div>
                <div class="project-links">
                    <a href="#" class="project-btn"><i class="fas fa-eye"></i> View Demo</a>
                    <a href="#" class="project-btn"><i class="fab fa-github"></i> Source Code</a>
                </div>
            </div>
        </div>

        <div class="project-card">
            <div class="project-image">
                <img src="../images/project3.jpg" alt="Data Analytics Platform">
            </div>
            <div class="project-content">
                <h3>Computer Based Test (CBT) Software</h3>
                <p>Computer Resource for taking test</p>
                <div class="tech-stack">
                    <span>Laravel</span>
                    <span>Bootstrap</span>
                    <span>MySQL</span>
                </div>
                <div class="project-links">
                    <a href="#" class="project-btn"><i class="fas fa-eye"></i> View Demo</a>
                    <a href="#" class="project-btn"><i class="fab fa-github"></i> Source Code</a>
                </div>
            </div>
        </div>

        <!-- <div class="project-card">
            <div class="project-image">
                <img src="../images/project4.jpg" alt="Security Analysis Tool">
            </div>
            <div class="project-content">
                <h3>Security Analysis Tool</h3>
                <p>Network security monitoring and threat detection</p>
                <div class="tech-stack">
                    <span>Python</span>
                    <span>Django</span>
                    <span>React</span>
                </div>
                <div class="project-links">
                    <a href="#" class="project-btn"><i class="fas fa-eye"></i> View Demo</a>
                    <a href="#" class="project-btn"><i class="fab fa-github"></i> Source Code</a>
                </div>
            </div>
        </div> -->
    </section>
</main>

<?php include '../components/footer.php'; ?> 