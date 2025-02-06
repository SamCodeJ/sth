<?php
$isHomePage = false;
include '../components/pages_header.php';
?>

<main class="register-page">
    <?php include '../components/navigation.php'; ?>

    <section class="page-header register-header">
        <h1><i class="fas fa-user-plus"></i> Join Our Tech Community</h1>
        <p>Start your journey towards a successful tech career</p>
    </section>

    <section class="register-content">
        <div class="register-container">
            <!-- Add message container -->
            <div id="message-container" style="display: none;">
                <div class="alert">
                    <span class="message-text"></span>
                    <span class="close-btn">&times;</span>
                </div>
            </div>

            <div class="register-left">
                <div class="form-header">
                    <h2>Registration Form</h2>
                    <p>Please fill in your details below</p>
                </div>

                <form class="register-form" id="registration-form" action="../includes/process_form.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fullname"><i class="fas fa-user"></i> Full Name</label>
                            <input type="text" id="fullname" name="fullname" required>
                        </div>
                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone"><i class="fas fa-phone"></i> Phone Number</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="course"><i class="fas fa-laptop-code"></i> Preferred Course</label>
                            <select id="course" name="course" required>
                                <option value="">Select a course</option>
                                <option value="web-development">Web Development</option>
                                <option value="cloud-computing">Cloud Computing</option>
                                <option value="cybersecurity">Cybersecurity</option>
                                <option value="data-science">Data Science</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                            <input type="text" id="address" name="address" placeholder="Optional">
                        </div>
                        <div class="form-group">
                            <label for="dob"><i class="fas fa-calendar"></i> Date of Birth</label>
                            <input type="date" id="dob" name="date_of_birth" placeholder="Optional">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="education"><i class="fas fa-graduation-cap"></i> Education Level</label>
                            <select id="education" name="education_level">
                                <option value="">Select Education Level (Optional)</option>
                                <option value="High School">High School</option>
                                <option value="Undergraduate">Undergraduate</option>
                                <option value="Graduate">Graduate</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="payment_method"><i class="fas fa-credit-card"></i> Payment Method</label>
                            <select id="payment_method" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Cash">Cash</option>
                                <option value="Online Payment">Online Payment</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message"><i class="fas fa-comment"></i> Tell us about yourself</label>
                        <textarea id="message" name="message" rows="4" placeholder="Your background, goals, and what interests you about the course"></textarea>
                    </div>

                    <div class="terms-container">
                        <input type="checkbox" id="terms-checkbox" required>
                        <label for="terms-checkbox">
                            I agree to the terms and conditions and privacy policy
                        </label>
                    </div>

                    <button type="submit" class="register-button">
                        <i class="fas fa-paper-plane"></i> Submit Application
                    </button>
                </form>
            </div>

            <div class="register-right">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Why Choose Us?</h3>
                    <ul>
                        <li><i class="fas fa-check"></i> Industry-expert instructors</li>
                        <li><i class="fas fa-check"></i> Hands-on practical training</li>
                        <li><i class="fas fa-check"></i> Career support services</li>
                        <li><i class="fas fa-check"></i> Flexible learning options</li>
                    </ul>
                </div>

                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3>Next Steps</h3>
                    <div class="steps">
                        <div class="step">
                            <span class="step-number">1</span>
                            <p>Submit Registration</p>
                        </div>
                        <div class="step">
                            <span class="step-number">2</span>
                            <p>Receive Confirmation</p>
                        </div>
                        <div class="step">
                            <span class="step-number">3</span>
                            <p>Schedule Orientation</p>
                        </div>
                        <div class="step">
                            <span class="step-number">4</span>
                            <p>Begin Learning</p>
                        </div>
                    </div>
                </div>

                <div class="support-card">
                    <h3><i class="fas fa-headset"></i> Need Help?</h3>
                    <p>Our support team is here to assist you</p>
                    <div class="support-contact">
                        <a href="mailto:support@stellartechhub.com" class="support-link">
                            <i class="fas fa-envelope"></i> support@stellartechhub.com
                        </a>
                        <a href="tel:+447393667781" class="support-link">
                            <i class="fas fa-phone"></i>+44 7393 667 781
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="../script.js"></script>
<?php include '../components/footer.php'; ?>

<!-- Add JavaScript for form handling -->
<script>
document.getElementById('registration-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    
    fetch('../includes/process_form.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const messageContainer = document.getElementById('message-container');
        const alert = messageContainer.querySelector('.alert');
        const messageText = messageContainer.querySelector('.message-text');
        
        messageContainer.style.display = 'block';
        
        if (data.status === 'success') {
            alert.className = 'alert alert-success';
            messageText.textContent = 'Registration successful! We will contact you shortly.';
            document.getElementById('registration-form').reset();
            // Scroll to message
            messageContainer.scrollIntoView({ behavior: 'smooth' });
        } else {
            alert.className = 'alert alert-error';
            messageText.textContent = data.message || 'Registration failed. Please try again.';
        }
    })
    .catch(error => {
        const messageContainer = document.getElementById('message-container');
        const alert = messageContainer.querySelector('.alert');
        const messageText = messageContainer.querySelector('.message-text');
        
        messageContainer.style.display = 'block';
        alert.className = 'alert alert-error';
        messageText.textContent = 'An error occurred. Please try again later.';
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Application';
    });
});

// Close button functionality
document.querySelector('.close-btn').addEventListener('click', function() {
    document.getElementById('message-container').style.display = 'none';
});
</script>