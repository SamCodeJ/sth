<?php 
$isHomePage = false;
include '../components/pages_header.php'; 
?>

<main class="about-page">
    <?php include '../components/navigation.php'; ?>
    
    <!-- Hero Section -->
    <section class="about-hero" style="background: #1B2B4C; height: 40vh; margin-top: 80px;">
        <div class="about-hero-content">
            <h1 style="font-size: 3.5rem;">About Us</h1>
            <p style="font-size: 1.2rem;">Learn more about our mission and values.</p>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="about-mission">
        <div class="container">
            <div class="mission-grid">
                <div class="mission-content">
                    <h2>Our Mission</h2>
                    <p>We are dedicated to providing high-quality tech education and training services to empower individuals and organizations in their digital journey.</p>
                    <a href="register.php" class="cta-button">Join Us Today</a>
                </div>
                <div class="mission-image">
                    <img src="../images/mission.jpg" alt="Our Mission">
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="about-values">
        <div class="container">
            <h2>Our Core Values</h2>
            <div class="values-grid">
                <div class="value-card">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Excellence in Education</h3>
                    <p>Delivering top-tier learning experiences through innovative teaching methods.</p>
                </div>
                <div class="value-card">
                    <i class="fas fa-users"></i>
                    <h3>Community Focus</h3>
                    <p>Building a supportive community of learners and tech enthusiasts.</p>
                </div>
                <div class="value-card">
                    <i class="fas fa-lightbulb"></i>
                    <h3>Innovation</h3>
                    <p>Staying at the forefront of technological advancement and industry trends.</p>
                </div>
                <div class="value-card">
                    <i class="fas fa-hands-helping"></i>
                    <h3>Student Success</h3>
                    <p>Prioritizing student growth and career development.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="about-team">
        <div class="container">
            <h2>Meet Our Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-image">
                        <img src="../images/team/member1.jpg" alt="Team Member">
                    </div>
                    <h3>John Doe</h3>
                    <p>Lead Instructor</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <!-- Add more team members as needed -->
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="about-stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">500+</span>
                    <p>Students Trained</p>
                </div>
                <div class="stat-item">
                    <span class="stat-number">50+</span>
                    <p>Expert Instructors</p>
                </div>
                <div class="stat-item">
                    <span class="stat-number">30+</span>
                    <p>Training Programs</p>
                </div>
                <div class="stat-item">
                    <span class="stat-number">95%</span>
                    <p>Success Rate</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../components/footer.php'; ?>
