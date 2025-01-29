-- Create secure user for application
CREATE USER 'stellar_app'@'127.0.0.1:3306' IDENTIFIED BY 'strong_password_here';

-- Grant specific permissions
GRANT SELECT, INSERT, UPDATE ON stellar_tech.students TO 'stellar_app'@'127.0.0.1:3306';
GRANT SELECT, INSERT, UPDATE ON stellar_tech.registrations TO 'stellar_app'@'127.0.0.1:3306';
GRANT SELECT, INSERT ON stellar_tech.payments TO 'stellar_app'@'127.0.0.1:3306';
GRANT SELECT ON stellar_tech.courses TO 'stellar_app'@'127.0.0.1:3306';

-- Create admin user with full permissions
CREATE USER 'stellar_admin'@'127.0.0.1:3306' IDENTIFIED BY 'admin_strong_password';
GRANT ALL PRIVILEGES ON stellar_tech.* TO 'stellar_admin'@'127.0.0.1:3306';

-- Add indexes for better performance and security
ALTER TABLE students ADD INDEX idx_email (email);
ALTER TABLE students ADD INDEX idx_phone (phone);
ALTER TABLE registrations ADD INDEX idx_registration_date (registration_date);
ALTER TABLE payments ADD INDEX idx_payment_date (payment_date);
ALTER TABLE activity_logs ADD INDEX idx_created_at (created_at);

-- Add triggers for additional security
DELIMITER //

CREATE TRIGGER before_payment_insert
BEFORE INSERT ON payments
FOR EACH ROW
BEGIN
    IF NEW.amount <= 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Payment amount must be greater than zero';
    END IF;
END//

CREATE TRIGGER after_admin_login
AFTER UPDATE ON admin_users
FOR EACH ROW
BEGIN
    IF NEW.last_login != OLD.last_login THEN
        INSERT INTO activity_logs (admin_id, action, description)
        VALUES (NEW.admin_id, 'LOGIN', 'Admin user logged in');
    END IF;
END//

DELIMITER ; 