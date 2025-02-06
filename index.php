<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Training</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- <script src="js/main.js" defer></script> -->
</head>
<body>
    <?php 
    $isHomePage = true;
    include 'components/header.php'; 
    ?>

    <main class="tech-hub">
        <?php include 'components/navigation.php'; ?>
        
        <!-- Slider Section -->
        <section class="hero-slider">
            <div class="slider">
                <div class="slide fade active">
                    <div class="slide-image">
                        <img src="images/slide1.jpg" alt="Tech Education">
                    </div>
                    <div class="slide-content-one slide-content">
                        <span class="event-tag">Free Webinar</span>
                        <h1>Master Machine Learning & Data Science</h1>
                        <p>Launch your AI and Data Science career! Join us live on March 30, 2024, at 2:00 PM GMT</p>
                        <div class="cta-buttons">
                            <a href="pages/webinar-register" class="webinar-btn primary">Reserve Your Spot <i class="fas fa-arrow-right"></i></a>
                            <span class="seats-left">Only 100 seats available</span>
                        </div>
                    </div>
                </div>

                <div class="slide fade">
                    <div class="slide-image">
                        <img src="images/slide2.jpg" alt="Expert Training">
                    </div>
                    <div class="slide-content">
                        <h1>Learn from Industry Experts</h1>
                        <p>Gain Real-World Experience</p>
                        <a href="pages/courses.php" class="slide-btn">View Courses</a>
                    </div>
                </div>

                <div class="slide fade">
                    <div class="slide-image">
                        <img src="images/slide3.jpg" alt="Career Growth">
                    </div>
                    <div class="slide-content">
                        <h1>Build Your Tech Career</h1>
                        <p>From Beginner to Professional</p>
                        <a href="pages/webinar-register.php" class="slide-btn">Join Now</a>
                    </div>
                </div>

                <!-- Navigation arrows -->
                <button class="slider-btn prev">&#10094;</button>
                <button class="slider-btn next">&#10095;</button>

                <!-- Dots/bullets/indicators -->
                <div class="slider-dots">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="stats-container">
                <div class="stat-item">
                    <h3>1000+</h3>
                    <p>Graduates</p>
                </div>
                <div class="stat-item">
                    <h3>95%</h3>
                    <p>Employment Rate</p>
                </div>
                <div class="stat-item">
                    <h3>50+</h3>
                    <p>Industry Partners</p>
                </div>
                <div class="stat-item">
                    <h3>20+</h3>
                    <p>Tech Courses</p>
                </div>
            </div>
        </section>

        <!-- Technologies Section -->
        <section class="tech-stack">
            <div class="section-header">
                <h2>Technologies You'll Master</h2>
                <p>Industry-standard tools and frameworks that power modern tech</p>
            </div>
            <div class="tech-grid">
                <div class="tech-item">
                    <div class="tech-icon">
                        <img src="images/tech/html5.svg" alt="HTML5">
                    </div>
                    <div class="tech-info">
                        <h3>HTML5</h3>
                        <p>Modern Web Structure</p>
                        <div class="tech-details">
                            <span>Semantic Markup</span>
                            <span>Web Standards</span>
                            <span>Accessibility</span>
                        </div>
                    </div>
                </div>

                <div class="tech-item">
                    <div class="tech-icon">
                        <img src="images/tech/css3.svg" alt="CSS3">
                    </div>
                    <div class="tech-info">
                        <h3>CSS3</h3>
                        <p>Stylish Designs</p>
                        <div class="tech-details">
                            <span>Flexbox</span>
                            <span>Grid</span>
                            <span>Animations</span>
                        </div>
                    </div>
                </div>

                <div class="tech-item">
                    <div class="tech-icon">
                        <img src="images/tech/javascript.svg" alt="JavaScript">
                    </div>
                    <div class="tech-info">
                        <h3>JavaScript</h3>
                        <p>Dynamic Interfaces</p>
                        <div class="tech-details">
                            <span>ES6+</span>
                            <span>DOM</span>
                            <span>APIs</span>
                        </div>
                    </div>
                </div>

                <div class="tech-item">
                    <div class="tech-icon">
                        <img src="images/tech/react.svg" alt="React">
                    </div>
                    <div class="tech-info">
                        <h3>React</h3>
                        <p>Modern UI Development</p>
                        <div class="tech-details">
                            <span>Components</span>
                            <span>Hooks</span>
                            <span>Redux</span>
                        </div>
                    </div>
                </div>

                <div class="tech-item">
                    <div class="tech-icon">
                        <img src="images/tech/python.svg" alt="Python">
                    </div>
                    <div class="tech-info">
                        <h3>Python</h3>
                        <p>Backend & AI</p>
                        <div class="tech-details">
                            <span>Django</span>
                            <span>Flask</span>
                            <span>ML</span>
                        </div>
                    </div>
                </div>

                <div class="tech-item">
                    <div class="tech-icon">
                        <img src="images/tech/nodejs.svg" alt="Node.js">
                    </div>
                    <div class="tech-info">
                        <h3>Node.js</h3>
                        <p>Server Development</p>
                        <div class="tech-details">
                            <span>Express</span>
                            <span>API</span>
                            <span>MongoDB</span>
                        </div>
                    </div>
                </div>

                <div class="tech-item">
                    <div class="tech-icon">
                        <img src="images/tech/aws.svg" alt="AWS">
                    </div>
                    <div class="tech-info">
                        <h3>AWS</h3>
                        <p>Cloud Computing</p>
                        <div class="tech-details">
                            <span>EC2</span>
                            <span>S3</span>
                            <span>Lambda</span>
                        </div>
                    </div>
                </div>

                <div class="tech-item">
                    <div class="tech-icon">
                        <img src="images/tech/mongodb.svg" alt="MongoDB">
                    </div>
                    <div class="tech-info">
                        <h3>MongoDB</h3>
                        <p>Database Management</p>
                        <div class="tech-details">
                            <span>NoSQL</span>
                            <span>Atlas</span>
                            <span>Aggregation</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Course Preview Section -->
        <section class="course-preview">
            <!-- ... existing course preview code ... -->
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials">
            <div class="section-header">
                <h2>What Our Students Have to Say</h2>
                <p>Real experiences from our tech community</p>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <!-- <div class="student-image">
                            <img src="images/testimonials/testimonial1.jpg" alt="John Doe">
                        </div> -->
                        <div class="student-info">
                            <h3>Daniel O.</h3>
                            <span>IT Consultant</span>
                            <div class="company">@Readefined Solutions</div>
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <div class="quote-icon">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p>"When we got to the machine learning models, it all clicked into place and made sense because we had by that time developed an understanding of the basic concepts. The teachers were there to answer queries and their help was invaluable."</p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="course-info">
                            <span>Course:</span>
                            <span class="course-name">Full Stack Development</span>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <!-- <div class="student-image">
                            <img src="images/testimonials/testimonial2.jpg" alt="Sarah Johnson">
                        </div> -->
                        <div class="student-info">
                            <h3>Adeola O.</h3>
                            <span>Data Analyst Intern</span>
                            <!-- <div class="company">@Microsoft</div> -->
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <div class="quote-icon">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p>"Advancing in Tech Development for Data Analytics and ML was a great decision. Practical learning and hands-on projects boosted my confidence and prepared me for data job applications."</p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="course-info">
                            <span>Course:</span>
                            <span class="course-name">UI/UX Design</span>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <!-- <div class="student-image">
                            <img src="images/testimonials/testimonial3.jpg" alt="Michael Chen">
                        </div> -->
                        <div class="student-info">
                            <h3>James K.</h3>
                            <span>Graduate Student</span>
                            <!-- <div class="company">@Amazon</div> -->
                        </div>
                    </div>
                    <div class="testimonial-content">
                        <div class="quote-icon">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p>"Before joining Stellar Tech Hub's training, I had little Python experience. In weeks, I gained skills in Data Processing, Visualization, and Machine Learning. The clear explanations made learning easy, and I highly recommend the course to anyone entering tech."</p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="course-info">
                            <span>Course:</span>
                            <span class="course-name">Data Science & AI</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Industry Partners Section -->
        <section class="partners">
            <!-- ... existing partners code ... -->
        </section>

        <!-- Why Choose Us Section -->
        <section class="why-choose-us">
            <div class="section-header">
                <h2>Why Choose Stellar Tech Hub?</h2>
                <p>Your success is our priority - here's what sets us apart</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Industry Expert Instructors</h3>
                        <p>Learn from professionals with years of real-world experience in top tech companies.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Hands-on Projects</h3>
                        <p>Build real-world projects that you can add to your portfolio and showcase to employers.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Career Support</h3>
                        <p>Get personalized career guidance, interview prep, and job placement assistance.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Flexible Learning</h3>
                        <p>Choose between full-time, part-time, and weekend classes to fit your schedule.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Industry Certification</h3>
                        <p>Earn recognized certifications that validate your skills to employers.</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Community Support</h3>
                        <p>Join a thriving community of learners and tech professionals for networking.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="cta-content">
                <h2>Start Your Tech Journey Today</h2>
                <p>Join thousands of successful graduates in the tech industry</p>
                <div class="cta-buttons">
                    <a href="pages/courses.php" class="cta-btn primary">View Courses</a>
                    <a href="pages/webinar-register.php" class="cta-btn secondary">Get Started</a>
                </div>
            </div>
        </section>
    </main>

    <script src="js/slider.js"></script>
    <script src="js/testimonials.js"></script>
    <script src="js/navigation.js"></script>

    <?php include 'components/footer.php'; ?>
</body>
</html> 