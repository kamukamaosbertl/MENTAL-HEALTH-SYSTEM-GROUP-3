<?php
session_start();
include('includes/db_connection.php');

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Set headers for CSV output
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="booked_sessions_report.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Write CSV headers
fputcsv($output, ['Name', 'Booking Date', 'Location', 'Phone', 'Email', 'Problem', 'Gender']);

// Fetch all bookings
$query = "SELECT name, booking_date, location, phone, email, problem, gender FROM bookings";
$result = $conn->query($query);

// Check for query errors
if (!$result) {
    fputcsv($output, ['Error retrieving data: ' . $conn->error]);
} else {
    // Write data rows to CSV
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
}

// Close output stream
fclose($output);
exit();
?>
