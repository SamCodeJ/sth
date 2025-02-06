<?php
require_once('../includes/config.php');
require_once('../includes/Database.php');

// Initialize Database
$db = new Database();

// Get all webinar registrations
$registrations = $db->query("SELECT * FROM webinar_registrations ORDER BY registration_date DESC");

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="webinar-registrations-' . date('Y-m-d') . '.csv"');

// Create output stream
$output = fopen('php://output', 'w');

// Add UTF-8 BOM for proper Excel encoding
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Add CSV headers
fputcsv($output, [
    'Full Name',
    'Email',
    'Phone',
    'Country',
    'Occupation',
    'Source',
    'Questions',
    'Registration Date'
]);

// Add data rows
foreach ($registrations as $registration) {
    fputcsv($output, [
        $registration['fullname'],
        $registration['email'],
        $registration['phone'],
        $registration['country'],
        $registration['occupation'],
        $registration['source'],
        $registration['questions'],
        $registration['registration_date']
    ]);
}

fclose($output);
exit(); 