-- Create the database
CREATE DATABASE IF NOT EXISTS stellar_tech;
USE stellar_tech;

-- Courses table
CREATE TABLE courses (
    course_id INT PRIMARY KEY AUTO_INCREMENT,
    course_name VARCHAR(255) NOT NULL,
    description TEXT,
    duration VARCHAR(100),
    price DECIMAL(10,2),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Students/Registrants table
CREATE TABLE IF NOT EXISTS students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    address TEXT,
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    education_level VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Registrations table (connects students with courses)
CREATE TABLE registrations (
    registration_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    course_id INT,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_status ENUM('pending', 'partial', 'completed') DEFAULT 'pending',
    amount_paid DECIMAL(10,2) DEFAULT 0.00,
    payment_method VARCHAR(50),
    status ENUM('active', 'completed', 'dropped') DEFAULT 'active',
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);

-- Payments table
CREATE TABLE payments (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    registration_id INT,
    amount DECIMAL(10,2) NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_method VARCHAR(50),
    transaction_reference VARCHAR(100),
    status ENUM('success', 'failed', 'pending') DEFAULT 'pending',
    FOREIGN KEY (registration_id) REFERENCES registrations(registration_id)
);

-- Admin users table
CREATE TABLE admin_users (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    role ENUM('super_admin', 'admin', 'staff') DEFAULT 'staff',
    last_login TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Activity logs table
CREATE TABLE activity_logs (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT,
    action VARCHAR(255) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admin_users(admin_id)
);

-- Insert default admin user (password: admin123)
INSERT INTO admin_users (username, password, full_name, email, role) 
VALUES ('admin', '$2y$10$YourHashedPasswordHere', 'System Admin', 'admin@stellartechhub.com', 'super_admin');

-- Insert sample courses
INSERT INTO courses (course_name, description, duration, price) VALUES
('Web Development Fundamentals', 'Learn HTML, CSS, and JavaScript basics', '3 months', 50000.00),
('Advanced PHP Programming', 'Master PHP and MySQL development', '4 months', 75000.00),
('Full Stack Development', 'Complete web development bootcamp', '6 months', 100000.00); 

ALTER TABLE students 
ADD COLUMN message TEXT AFTER education_level;

CREATE TABLE webinar_registrations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    occupation VARCHAR(255),
    questions TEXT,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE webinar_registrations 
ADD COLUMN country VARCHAR(100) AFTER phone,
ADD COLUMN source VARCHAR(50) AFTER occupation;

CREATE TABLE activity_logs (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(50) DEFAULT 'fas fa-info-circle',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES admin_users(admin_id)
);

-- Add role column to admin_users
ALTER TABLE admin_users ADD COLUMN role ENUM('super_admin', 'admin', 'editor') DEFAULT 'editor';

-- Create permissions table
CREATE TABLE permissions (
    permission_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description TEXT
);

-- Create role_permissions table
CREATE TABLE role_permissions (
    role VARCHAR(20),
    permission_id INT,
    FOREIGN KEY (permission_id) REFERENCES permissions(permission_id)
);