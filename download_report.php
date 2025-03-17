<?php
// Start session to manage user authentication
session_start();
include 'includes/db_connection.php';

// Log execution time start
$execution_start_time = microtime(true);

// Function to calculate cyclomatic complexity
function calculateCyclomaticComplexity($decisions) {
    return 1 + $decisions;
}

// Function to measure nesting depth
function calculateNestingDepth($code) {
    preg_match_all('/\b(if|for|while|switch)\b/', $code, $matches);
    return count($matches[0]);
}

// Function to measure information flow (Fan-in & Fan-out)
function calculateInformationFlow() {
    // Fan-in: Inputs from session and GET
    $fan_in = 2;
    // Fan-out: Outputs to database, headers, and error log
    $fan_out = 3;
    return $fan_in * $fan_out;
}

// Debugging and Logging: Unauthorized Access Check
if (!isset($_SESSION['user_id'])) {
    error_log("Unauthorized access attempt by IP: " . $_SERVER['REMOTE_ADDR']);
    header("Location: login.php");
    exit;
}

// Debugging and Logging: Missing Report ID
if (!isset($_GET['id'])) {
    error_log("Missing report ID in request by user ID: " . $_SESSION['user_id']);
    echo "Report ID is missing.";
    exit;
}

// Get the report ID from URL
$report_id = $_GET['id'];
error_log("Report ID Requested: " . $report_id);

// Query to fetch report
$stmt = $conn->prepare("SELECT * FROM users_reports WHERE report_id = ? AND user_id = ?");
$stmt->bind_param("ii", $report_id, $_SESSION['user_id']);
$stmt->execute();
$reportResult = $stmt->get_result();

if ($reportResult->num_rows > 0) {
    $report = $reportResult->fetch_assoc();
    $content = $report['report_content'];

    // Start measuring download time
    $download_start_time = microtime(true);

    // Set headers for file download
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="report_' . $report_id . '.txt"');

    // Output file content
    echo $content;

    // End measuring download time
    $download_end_time = microtime(true);
    $download_time = $download_end_time - $download_start_time;

    // Calculate file size
    $file_size = strlen($content); // Size in bytes

    // Log Download Time and Size
    error_log("Download time for Report ID: $report_id by User ID: " . $_SESSION['user_id'] . " was $download_time seconds.");
    error_log("Downloaded File Size: $file_size bytes");

} else {
    error_log("Failed download attempt for Report ID: " . $report_id . " by User ID: " . $_SESSION['user_id']);
    echo "Report not found or access denied.";
}

// Close resources
$stmt->close();
$conn->close();

// Log execution time end
$execution_end_time = microtime(true);
$execution_time = $execution_end_time - $execution_start_time;

// Code metrics calculations
$cyclomaticComplexity = calculateCyclomaticComplexity(3); // 3 Decision Points
$nestingDepth = calculateNestingDepth(file_get_contents(__FILE__));
$informationFlowComplexity = calculateInformationFlow();

// Log metrics
error_log("Cyclomatic Complexity: " . $cyclomaticComplexity);
error_log("Depth of Nesting: " . $nestingDepth);
error_log("Information Flow Complexity: " . $informationFlowComplexity);
error_log("Total Execution Time: " . $execution_time . " seconds");

?>
