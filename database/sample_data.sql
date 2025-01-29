-- Insert sample students
INSERT INTO students (full_name, email, phone, address, date_of_birth, gender, education_level) VALUES
('John Doe', 'john@example.com', '1234567890', '123 Main St', '1995-05-15', 'male', 'Bachelor'),
('Jane Smith', 'jane@example.com', '0987654321', '456 Oak Ave', '1998-08-22', 'female', 'High School'),
('Mike Johnson', 'mike@example.com', '5555555555', '789 Pine Rd', '1993-12-10', 'male', 'Master'),
('Sarah Williams', 'sarah@example.com', '4444444444', '321 Elm St', '1997-03-28', 'female', 'Bachelor');

-- Insert sample registrations
INSERT INTO registrations (student_id, course_id, payment_status, amount_paid, payment_method) VALUES
(1, 1, 'completed', 50000.00, 'bank_transfer'),
(2, 2, 'partial', 35000.00, 'cash'),
(3, 3, 'pending', 0.00, 'pending'),
(4, 1, 'completed', 50000.00, 'online');

-- Insert sample payments
INSERT INTO payments (registration_id, amount, payment_method, transaction_reference, status) VALUES
(1, 50000.00, 'bank_transfer', 'TRX123456', 'success'),
(2, 35000.00, 'cash', 'CASH789012', 'success'),
(4, 25000.00, 'online', 'ONL345678', 'success'),
(4, 25000.00, 'online', 'ONL345679', 'success'); 