-- Sessions table for secure login management
CREATE TABLE sessions (
    session_id VARCHAR(255) PRIMARY KEY,
    admin_id INT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    last_activity TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admin_users(admin_id)
);

-- Settings table for system configuration
CREATE TABLE settings (
    setting_id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(50) UNIQUE,
    setting_value TEXT,
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default settings
INSERT INTO settings (setting_key, setting_value, description) VALUES
('site_name', 'Stellar Tech Hub', 'Website name'),
('admin_email', 'admin@stellartechhub.com', 'Admin contact email'),
('registration_open', 'true', 'Whether course registration is open'),
('maintenance_mode', 'false', 'Site maintenance mode'); 


CREATE TABLE webinar_registrations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    occupation VARCHAR(255),
    questions TEXT,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);