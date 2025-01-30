<?php
require_once('../includes/config.php');
require_once('../includes/Database.php');
require_once('../includes/services/EmailService.php');

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Database();
        $emailService = new EmailService();
        
        // Debug: Print the POST data
        error_log('POST data: ' . print_r($_POST, true));
        
        // Validate and sanitize input with proper checks
        $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $country = isset($_POST['country']) ? trim($_POST['country']) : '';
        $occupation = isset($_POST['occupation']) ? trim($_POST['occupation']) : '';
        $source = isset($_POST['source']) ? trim($_POST['source']) : '';
        $questions = isset($_POST['questions']) ? trim($_POST['questions']) : '';
        
        // Debug: Print the processed values
        error_log("Fullname: $fullname, Email: $email");
        
        // Explicit validation with detailed error messages
        $errors = [];
        
        if (empty($fullname)) {
            $errors[] = "Full Name is required.";
        }
        
        if (empty($email)) {
            $errors[] = "Email Address is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address.";
        }
        
        if (!empty($errors)) {
            throw new Exception(implode("<br>", $errors));
        }
        
        // If we get here, validation passed
        $db->query(
            "INSERT INTO webinar_registrations (fullname, email, phone, country, occupation, source, questions) 
             VALUES (?, ?, ?, ?, ?, ?, ?)",
            [$fullname, $email, $phone, $country, $occupation, $source, $questions]
        );
        
        // Send confirmation email
        $emailService->sendWebinarRegistrationEmail($email, [
            'fullname' => $fullname,
            'email' => $email,
            'phone' => $phone
        ]);
        
        $success_message = "Thank you for registering! Please check your email for confirmation.";
        
    } catch (Exception $e) {
        error_log($e->getMessage());
        $error_message = "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webinar Registration - Tech Training</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Add jQuery for easier handling -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include('../components/pages_header.php'); ?>

    <div class="container">
        <div class="webinar-registration">
            <div class="registration-header">
                <h1><i class="fas fa-chalkboard-teacher"></i> Register for Webinar</h1>
                <p class="subtitle">Join us for an exciting learning experience!</p>
            </div>

            <!-- Add this right after your form starts, before the form fields -->
            <div id="messageContainer"></div>

            <form method="POST" action="" class="registration-form" id="webinarForm" novalidate>
                <div class="form-group">
                    <label>
                        <i class="fas fa-user"></i> Full Name <span class="required">*</span>
                    </label>
                    <input type="text" 
                           id="fullname" 
                           name="fullname" 
                           required 
                           placeholder="Enter your full name"
                           value="<?php echo htmlspecialchars($_POST['fullname'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-envelope"></i> Email Address <span class="required">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           required 
                           placeholder="Enter your email address"
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">
                            <i class="fas fa-phone"></i> Phone Number
                        </label>
                        <input type="tel" id="phone" name="phone"
                               placeholder="Enter your phone number"
                               value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="country">
                            <i class="fas fa-globe"></i> Country
                        </label>
                        <input type="text" id="country" name="country"
                               placeholder="Enter your country"
                               value="<?php echo htmlspecialchars($_POST['country'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="occupation">
                            <i class="fas fa-briefcase"></i> Occupation
                        </label>
                        <input type="text" id="occupation" name="occupation"
                               placeholder="Enter your occupation"
                               value="<?php echo htmlspecialchars($_POST['occupation'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="source">
                            <i class="fas fa-search"></i> How did you hear about us? <span class="required">*</span>
                        </label>
                        <select name="source" id="source" required>
                            <option value="">Select an option...</option>
                            <option value="Social Media">Social Media</option>
                            <option value="Search Engine">Search Engine</option>
                            <option value="Friend">Friend Referral</option>
                            <option value="Email">Email</option>
                            <option value="Advertisement">Advertisement</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="questions">
                        <i class="fas fa-question-circle"></i> Questions or Comments
                    </label>
                    <textarea id="questions" name="questions" 
                              placeholder="Any questions or comments?"
                              rows="4"><?php echo htmlspecialchars($_POST['questions'] ?? ''); ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="btn-content">
                            <i class="fas fa-paper-plane"></i> Register Now
                        </span>
                        <span class="btn-loading">
                            <i class="fas fa-spinner fa-spin"></i> Registering...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include('../components/footer.php'); ?>

    <style>
    .webinar-registration {
        max-width: 900px;
        margin: 40px auto;
        padding: 40px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .registration-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .registration-header h1 {
        color: #2c3e50;
        font-size: 2.5em;
        margin-bottom: 10px;
    }

    .registration-header .subtitle {
        color: #7f8c8d;
        font-size: 1.1em;
    }

    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        flex: 1;
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #2c3e50;
        font-weight: 500;
    }

    .form-group label i {
        margin-right: 8px;
        color: #3498db;
    }

    .required {
        color: #e74c3c;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        outline: none;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-actions {
        margin-top: 30px;
    }

    .btn-submit,
    .btn-reset {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-submit {
        width: 100%;
        padding: 15px 30px;
        background: #3498db;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .btn-reset {
        background: #f1f1f1;
        color: #666;
        flex: 1;
    }

    .btn-submit:hover {
        background: #2980b9;
        transform: translateY(-2px);
    }

    .btn-reset:hover {
        background: #e0e0e0;
    }

    .btn-submit:disabled {
        background: #95a5a6;
        cursor: not-allowed;
    }

    .alert {
        padding: 15px;
        margin-bottom: 25px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }

        .webinar-registration {
            padding: 20px;
            margin: 20px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-submit,
        .btn-reset {
            width: 100%;
        }
    }

    .btn-submit {
        position: relative;
        overflow: hidden;
    }

    .btn-submit .btn-content,
    .btn-submit .btn-loading {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-submit .btn-loading {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: inherit;
        opacity: 0;
        visibility: hidden;
    }

    .btn-submit.loading .btn-content {
        opacity: 0;
        visibility: hidden;
    }

    .btn-submit.loading .btn-loading {
        opacity: 1;
        visibility: visible;
    }

    /* Disabled state styles */
    .btn-submit:disabled {
        background: #7fb9e2;
        cursor: not-allowed;
        transform: none !important;
    }

    /* Loading spinner animation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .fa-spinner {
        animation: spin 1s linear infinite;
    }

    /* Style for disabled form elements */
    input:disabled,
    select:disabled,
    textarea:disabled {
        background-color: #f8f9fa;
        cursor: not-allowed;
        opacity: 0.7;
    }

    /* Optional: Add overlay to form while submitting */
    .form-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .form-overlay.active {
        display: flex;
    }

    /* Loading indicator styles */
    .loading-indicator {
        text-align: center;
        color: #3498db;
    }

    .loading-indicator i {
        font-size: 2em;
        margin-bottom: 10px;
    }

    /* Add these styles to make the form more responsive to user input */
    .form-group input:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
    }

    .form-group input.error {
        border-color: #e74c3c;
    }

    .error-message {
        color: #e74c3c;
        font-size: 0.875em;
        margin-top: 5px;
    }

    /* Make sure buttons are clearly visible */
    .btn-submit {
        background: #3498db;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        font-size: 16px;
        margin-top: 20px;
    }

    .btn-submit:hover {
        background: #2980b9;
    }

    .btn-submit:disabled {
        background: #95a5a6;
        cursor: not-allowed;
    }

    #messageContainer {
        margin-bottom: 20px;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideIn 0.3s ease-out;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert i {
        font-size: 1.2em;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Fade out animation */
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }

    .alert.fade-out {
        animation: fadeOut 0.5s ease-out forwards;
    }

    .form-group select {
        width: 100%;
        padding: 12px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 16px;
        background-color: white;
        transition: all 0.3s ease;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1em;
        padding-right: 40px;
    }

    .form-group select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        outline: none;
    }

    .form-group select:required:invalid {
        color: #757575;
    }

    .form-group select option[value=""] {
        color: #757575;
    }

    .form-group select option {
        color: #2c3e50;
    }
    </style>

    <script>
    $(document).ready(function() {
        $('#webinarForm').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $('#submitBtn');
            
            // Get form data
            const formData = new FormData(this);
            
            // Show loading state
            $submitBtn.prop('disabled', true).addClass('loading');
            
            // Submit form using AJAX
            $.ajax({
                type: 'POST',
                url: $form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    showMessage('Thank you for registering! Please check your email for confirmation.', 'success');
                    $form[0].reset();
                },
                error: function(xhr, status, error) {
                    showMessage('Registration failed. Please try again.', 'error');
                },
                complete: function() {
                    // Always remove loading state
                    $submitBtn.prop('disabled', false).removeClass('loading');
                }
            });
        });

        // Function to show messages
        function showMessage(message, type) {
            const $messageContainer = $('#messageContainer');
            $messageContainer.html(`
                <div class="alert alert-${type}">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                    ${message}
                </div>
            `);

            // Scroll to message
            $('html, body').animate({
                scrollTop: $messageContainer.offset().top - 20
            }, 500);

            // If it's a success message, fade it out after 5 seconds
            if (type === 'success') {
                setTimeout(function() {
                    $messageContainer.find('.alert').fadeOut();
                }, 5000);
            }
        }
    });
    </script>
</body>
</html> 