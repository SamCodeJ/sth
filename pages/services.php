<?php 
$isHomePage = false;
include '../components/pages_header.php'; 
?>

<main class="services-page">
    <?php include '../components/navigation.php'; ?>
    
    <section class="page-header">
        <h1><i class="fas fa-cogs"></i> Our Services</h1>
        <p>Discover our comprehensive tech education services</p>
    </section>

    <section class="services-grid">
        <div class="service-card">
            <div class="service-icon">
                <i class="fas fa-laptop-code"></i>
            </div>
            <h3>Machine Learning</h3>
            <p>Learn modern web development technologies and frameworks. Build responsive and dynamic websites.</p>
            <ul>
                <li>Machine Learning</li>
                <li>Data Science</li>
                <li>Python</li>
            </ul>
            <a href="register.php" class="service-btn">Get Started</a>
        </div>

        <div class="service-card">
            <div class="service-icon">
                <i class="fas fa-laptop-code"></i>
            </div>
            <h3>Web Development</h3>
            <p>Learn modern web development technologies and frameworks. Build responsive and dynamic websites.</p>
            <ul>
                <li>Frontend Development</li>
                <li>Backend Development</li>
                <li>Full Stack Training</li>
            </ul>
            <a href="register.php" class="service-btn">Get Started</a>
        </div>

        <div class="service-card">
            <div class="service-icon">
                <i class="fas fa-cloud"></i>
            </div>
            <h3>Cloud Computing</h3>
            <p>Master cloud platforms and services. Learn deployment and management strategies.</p>
            <ul>
                <li>AWS Certification</li>
                <li>Azure Solutions</li>
                <li>Cloud Architecture</li>
            </ul>
            <a href="register.php" class="service-btn">Get Started</a>
        </div>

        <div class="service-card">
            <div class="service-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h3>Cybersecurity</h3>
            <p>Learn to protect systems and networks. Master security protocols and best practices.</p>
            <ul>
                <li>Network Security</li>
                <li>Ethical Hacking</li>
                <li>Security Analysis</li>
            </ul>
            <a href="register.php" class="service-btn">Get Started</a>
        </div>

        <div class="service-card">
            <div class="service-icon">
                <i class="fas fa-database"></i>
            </div>
            <h3>Data Science</h3>
            <p>Explore data analysis and machine learning. Transform data into insights.</p>
            <ul>
                <li>Data Analysis</li>
                <li>Machine Learning</li>
                <li>Business Intelligence</li>
            </ul>
            <a href="register.php" class="service-btn">Get Started</a>
        </div>
    </section>
</main>
<script src="../script.js"></script>
<?php include '../components/footer.php'; ?> 