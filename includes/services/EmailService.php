<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    private $mailer;
    private $db;
    
    public function __construct() {
        require_once __DIR__ . '/../config.php';
        require_once __DIR__ . '/../Database.php';
        
        // Initialize PHPMailer
        require_once __DIR__ . '/../../vendor/autoload.php';
        
        $this->mailer = new PHPMailer(true);
        $this->db = new Database();
        $this->setupMailer();
    }
    
    private function setupMailer() {
        try {
            // Server settings
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.hostinger.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'registration@stellartechub.com';
            $this->mailer->Password = 'u&4au#eZJnEC'; // Make sure this is correct
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Changed to SMTPS for port 465
            $this->mailer->Port = 465;
            
            // Set debug level (remove in production)
            $this->mailer->SMTPDebug = 2; // Add this temporarily for debugging
            
            // Default sender
            $this->mailer->setFrom('registration@stellartechub.com', 'Stellar Tech Hub');
            $this->mailer->isHTML(true);
        } catch (Exception $e) {
            error_log("Mailer setup failed: " . $e->getMessage());
            throw new Exception("Email service configuration failed: " . $e->getMessage());
        }
    }
    
    public function sendWebinarRegistrationEmail($to, $data) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            
            $this->mailer->Subject = "Welcome to Stellar Tech Hub Webinar!";
            
            // Get email template
            $template = $this->getEmailTemplate('webinar_registration');
            $body = $this->replaceTemplatePlaceholders($template, $data);
            
            $this->mailer->Body = $body;
            $this->mailer->AltBody = strip_tags($body);
            
            $sent = $this->mailer->send();
            if (!$sent) {
                error_log("Email not sent. Mailer Error: " . $this->mailer->ErrorInfo);
                throw new Exception("Failed to send email: " . $this->mailer->ErrorInfo);
            }
            return true;
        } catch (Exception $e) {
            error_log("Failed to send webinar registration email: " . $e->getMessage());
            throw new Exception("Failed to send confirmation email: " . $e->getMessage());
        }
    }
    
    private function getEmailTemplate($template_name) {
        switch ($template_name) {
            case 'webinar_registration':
                return '
                    <!DOCTYPE html>
                    <html>
                    <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                        <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                            <h2 style="color: #3498db;">Welcome to Stellar Tech Hub Webinar!</h2>
                            <p>Dear {fullname},</p>
                            <p>Thank you for registering for our upcoming webinar. We\'re excited to have you join us!</p>
                            <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
                                <h3 style="margin-top: 0;">Your Registration Details:</h3>
                                <ul style="list-style: none; padding: 0;">
                                    <li>📝 Name: {fullname}</li>
                                    <li>📧 Email: {email}</li>
                                    <li>📱 Phone: {phone}</li>
                                </ul>
                            </div>
                            <p><strong>Next Steps:</strong></p>
                            <ul>
                                <li>Save the date in your calendar</li>
                                <li>Check your email for webinar access details (coming soon)</li>
                                <li>Prepare your questions for the Q&A session</li>
                            </ul>
                            <p>We\'ll send you the webinar link and additional information closer to the event date.</p>
                            <p style="margin-top: 30px;">Best regards,<br>Stellar Tech Hub Team</p>
                        </div>
                    </body>
                    </html>
                ';
            default:
                throw new Exception("Email template not found");
        }
    }
    
    private function replaceTemplatePlaceholders($template, $data) {
        foreach ($data as $key => $value) {
            $template = str_replace('{' . $key . '}', htmlspecialchars($value), $template);
        }
        return $template;
    }
} 