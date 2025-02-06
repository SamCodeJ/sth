<?php 
$isHomePage = false;
include '../components/pages_header.php'; 
?>

<main class="info-page">
    <?php include '../components/navigation.php'; ?>
    
    <section class="page-header">
        <h1><i class="fas fa-info-circle"></i> Information Center</h1>
        <p>Everything you need to know about Stellar Tech Hub</p>
    </section>

    <section class="info-content">
        <div class="info-grid">
            <div class="info-card about-us">
                <div class="info-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h2>About Us</h2>
                <p>Stellar Tech Hub is a leading technology education institution dedicated to empowering individuals with cutting-edge tech skills. We believe in hands-on learning and practical experience.</p>
            </div>

            <div class="social-card">
    <h3>Connect With Us</h3>
    <div class="social-links">
        <a href="https://web.facebook.com/stellarTechHub" target="_blank" class="social-link facebook">
            <i class="fab fa-facebook-f"></i>
            Facebook
        </a>
        
        <a href="https://x.com/StellarTechHub/" target="_blank" class="social-link twitter">
            <i class="fab fa-x-twitter"></i>
            X (Twitter)
        </a>
        
        <a href="https://www.instagram.com/stellartechhub21/" target="_blank" class="social-link instagram">
            <i class="fab fa-instagram"></i>
            Instagram
        </a>
    </div>
</div>

            <div class="info-card mission">
                <div class="info-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h2>Our Mission</h2>
                <p>To provide accessible, high-quality technology education that prepares students for successful careers in the digital age. We strive to create innovative learning experiences that inspire and transform.</p>
            </div>

            <div class="info-card facilities">
                <div class="info-icon">
                    <i class="fas fa-laptop"></i>
                </div>
                <h2>Facilities</h2>
                <ul>
                    <li>Modern Computer Labs</li>
                    <li>High-Speed Internet</li>
                    <li>Study Areas</li>
                    <li>Conference Rooms</li>
                </ul>
            </div>

            <div class="info-card contact">
                <div class="info-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h2>Contact Us</h2>
                <ul>
                    <li><i class="fas fa-phone"></i>+44 7393 667 781</li>
                    <li><i class="fas fa-envelope"></i> info@stellartechhub.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> 123 Tech Street, Innovation City</li>
                </ul>
            </div>

            <div class="info-card schedule">
                <div class="info-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h2>Schedule</h2>
                <ul>
                    <li>Monday - Friday: 8:00 AM - 6:00 PM</li>
                    <li>Saturday: 9:00 AM - 3:00 PM</li>
                    <li>Sunday: Closed</li>
                </ul>
            </div>

            <div class="info-card faq">
                <div class="info-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h2>FAQ</h2>
                <div class="faq-item">
                    <h3>How long are the courses?</h3>
                    <p>Course duration varies from 3 to 6 months, depending on the program.</p>
                </div>
                <div class="faq-item">
                    <h3>Do you offer online classes?</h3>
                    <p>Yes, we offer both in-person and online learning options.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="../script.js"></script>
<?php include '../components/footer.php'; ?> 