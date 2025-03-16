<?php
session_start();
include 'includes/db_connection.php'; // Database connection
include 'includes/helpers.php'; // Helper functions

// Debugging checks
if (!isset($conn)) {
    die("Error: Database connection (\$conn) is missing.");
}
if (!function_exists('bookSession')) {
    die("Error: bookSession() function is not found.");
}

// Redirect if user is not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = bookSession($conn, $_POST, $_FILES['picture'] ?? null);
    
    // Log success or failure
    if (strpos($response, "Error") !== false) {
        error_log("Failed booking attempt: " . $response);
    } else {
        error_log("Successful session booking by User ID: " . $_SESSION['user_id']);
    }

    // Display success/error message
    echo "<script>alert('$response');</script>";
}

// --- SOFTWARE METRICS IMPLEMENTATION ---

// Start execution timer
$execution_start_time = microtime(true);

// Function to calculate cyclomatic complexity
function calculateCyclomaticComplexity($code) {
    preg_match_all('/\b(if|for|while|switch|case)\b/', $code, $matches);
    return 1 + count($matches[0]);
}

// Function to measure Lines of Code (LOC)
function calculateLOC($file) {
    $lines = file($file);
    $loc = 0;
    foreach ($lines as $line) {
        if (trim($line) !== '' && strpos(trim($line), '//') !== 0) {
            $loc++;
        }
    }
    return $loc;
}

// Function to calculate Halstead Metrics
function calculateHalsteadMetrics($code) {
    preg_match_all('/[+\-*\/=<>!&|%^~]/', $code, $operators);
    preg_match_all('/\b[a-zA-Z_][a-zA-Z0-9_]*\b/', $code, $operands);

    $n1 = count(array_unique($operators[0])); // Unique operators
    $n2 = count(array_unique($operands[0]));  // Unique operands
    $N1 = count($operators[0]);               // Total operators
    $N2 = count($operands[0]);                // Total operands

    if ($n1 == 0 || $n2 == 0) return null;

    $vocabulary = $n1 + $n2;
    $length = $N1 + $N2;
    $volume = $length * log($vocabulary, 2);
    $difficulty = ($n1 / 2) * ($N2 / $n2);
    $effort = $difficulty * $volume;
    $bugs = $volume / 3000;

    return compact('vocabulary', 'length', 'volume', 'difficulty', 'effort', 'bugs');
}

// Execution time tracking
$execution_end_time = microtime(true);
$execution_time = $execution_end_time - $execution_start_time;

// Read the current file content for analysis
$code = file_get_contents(__FILE__);
$cyclomaticComplexity = calculateCyclomaticComplexity($code);
$loc = calculateLOC(__FILE__);
$halstead = calculateHalsteadMetrics($code);

// Log all metrics
error_log("Cyclomatic Complexity: " . $cyclomaticComplexity);
error_log("Lines of Code (LOC): " . $loc);
error_log("Halstead Metrics: " . json_encode($halstead));
error_log("Total Execution Time: " . $execution_time . " seconds");

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Booking Form</title>
    <link rel="stylesheet" href="CSS/booking.css">
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <div class="form-container">
        <form action="booking.php" method="POST" enctype="multipart/form-data">
            <h1>Book a Session</h1>

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label for="telephone">Telephone</label>
                <input type="text" name="telephone" id="telephone" required>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" required>
            </div>

            <div class="form-group">
                <label for="problem">Describe Your Problem</label>
                <textarea name="problem" id="problem" required></textarea>
            </div>

            <div class="form-group">
                <label for="gender">Gender Preference</label>
                <select name="gender" id="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="any">Any</option>
                </select>
            </div>

            <div class="form-group">
                <label for="picture">Upload Your Picture (optional)</label>
                <input type="file" name="picture" id="picture">
            </div>

            <button type="submit">Submit Booking</button>
        </form>
    </div>
</body>
</html>
