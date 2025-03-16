<?php
// Start the session to manage user login sessions
session_start();
include 'includes/db_connection.php';

// Debug: Check if the session is set properly
if (!isset($_SESSION['user_id'])) {
    // Log unauthorized access attempt
    error_log("Unauthorized access attempt by IP: " . $_SERVER['REMOTE_ADDR']);
    // Redirect to the login page
    header("Location: login.php");
    exit;
}

// Check if the report ID is set in the URL
if (!isset($_GET['id'])) {
    // Log missing report ID
    error_log("Missing report ID in request by user ID: " . $_SESSION['user_id']);
    echo "Report ID is missing.";
    exit;
}

// Get the report ID from the URL
$report_id = $_GET['id'];


echo 'Report ID: ' . $report_id . '<br>';  

// Fetch the report based on the ID
$stmt = $conn->prepare("SELECT * FROM users_reports WHERE report_id = ? AND user_id = ?");
$stmt->bind_param("ii", $report_id, $_SESSION['user_id']);
$stmt->execute();
$reportResult = $stmt->get_result();

if ($reportResult->num_rows > 0) {
    $report = $reportResult->fetch_assoc();
    $content = $report['report_content'];

    // Start measuring download time
    $start_time = microtime(true);

    // Set headers to trigger download
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="report_' . $report_id . '.txt"');
    echo $content; // Output the content

    // End measuring download time
    $end_time = microtime(true);
    $download_time = $end_time - $start_time;

    // Log download time
    error_log("Download time for report ID: " . $report_id . " by user ID: " . $_SESSION['user_id'] . " was " . $download_time . " seconds.");
} else {
    // Log failed download attempt
    error_log("Failed download attempt for report ID: " . $report_id . " by user ID: " . $_SESSION['user_id']);
    echo "Report not found or access denied.";
}

$stmt->close(); // Close the statement
$conn->close(); // Close the database connection
?>