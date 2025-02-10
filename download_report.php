<?php
// Start the session to manage user login sessions
session_start();
include 'includes/db_connection.php';

// Debug: Check if the session is set properly
if (!isset($_SESSION['user_id'])) {
    // If the session is not set, redirect to the login page
    echo "User is not logged in. Redirecting to login page...";
    header("Location: login.php");
    exit;
}

// Check if the report ID is set in the URL
if (!isset($_GET['id'])) {
    echo "Report ID is missing.";
    exit;
}

// Get the report ID from the URL
$report_id = $_GET['id'];

// Debugging: Show the report ID (optional)
echo 'Report ID: ' . $report_id . '<br>';  // This is for debugging purposes

// Fetch the report based on the ID
$stmt = $conn->prepare("SELECT * FROM users_reports WHERE report_id = ? AND user_id = ?");
$stmt->bind_param("ii", $report_id, $_SESSION['user_id']);
$stmt->execute();
$reportResult = $stmt->get_result();

if ($reportResult->num_rows > 0) {
    $report = $reportResult->fetch_assoc();
    $content = $report['report_content'];

    // Set headers to trigger download
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="report_' . $report_id . '.txt"');
    echo $content; // Output the content
} else {
    echo "Report not found or access denied.";
}

$stmt->close(); // Close the statement
$conn->close(); // Close the database connection
?>
