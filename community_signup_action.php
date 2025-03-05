<?php
session_start(); // Start session to manage user signup sessions

// Enable debugging for errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include('includes/db_connection.php');

// Start execution time measurement
$start_time = microtime(true);

// Check the database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Initialize software metrics
$metrics = [
    "error_count" => 0,  // Track number of errors
    "query_count" => 0,  // Track number of queries executed
    "execution_time" => 0,
    "failure_type" => [] // Store types of failures
];

// Ensure logs folder exists
$log_dir = 'logs';
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0775, true);
}

// Ensure metrics.log file exists
$log_file = "$log_dir/metrics.log";
if (!file_exists($log_file)) {
    file_put_contents($log_file, "Metrics Log Created: " . date("Y-m-d H:i:s") . "\n");
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize user input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']); // Selected role

    // Perform validation on email and password
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        $metrics["error_count"]++;
        $metrics["failure_type"][] = "Invalid Email Format";
    } elseif (strlen($password) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters long.";
        $metrics["error_count"]++;
        $metrics["failure_type"][] = "Weak Password";
    } else {
        // Check if the email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        if (!$stmt) {
            die("Statement preparation failed: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $metrics["query_count"]++; // Query executed
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error'] = "Email is already registered.";
            $metrics["error_count"]++;
            $metrics["failure_type"][] = "Duplicate Email";
            header("Location: register.php"); // Redirect to registration page
            exit();
        } else {
            // Secure password hashing
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $stmt_id = $conn->prepare("INSERT INTO users (fullname, email, password_hash) VALUES (?, ?, ?)");
            if (!$stmt_id) {
                die("Statement preparation failed: " . $conn->error);
            }

            $stmt_id->bind_param("sss", $name, $email, $password_hash);
            if ($stmt_id->execute()) {
                $metrics["query_count"]++; // Query executed
                $user_id = $stmt_id->insert_id;

                // Insert user role in community_members table
                $stmt = $conn->prepare("INSERT INTO community_members (user_id, role) VALUES (?, ?)");
                if (!$stmt) {
                    die("Statement preparation failed: " . $conn->error);
                }

                $stmt->bind_param("is", $user_id, $role);
                if ($stmt->execute()) {
                    $metrics["query_count"]++; // Query executed
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['success'] = "Registration successful!";
                    header("Location: dashboard.php"); // Redirect after success
                    exit();
                } else {
                    $_SESSION['error'] = "Error saving information: " . $stmt->error;
                    $metrics["error_count"]++;
                    $metrics["failure_type"][] = "User Role Insert Error";
                }
            } else {
                $_SESSION['error'] = "Error saving information: " . $stmt_id->error;
                $metrics["error_count"]++;
                $metrics["failure_type"][] = "Database Insert Error";
            }

            // Close statements
            $stmt_id->close();
        }
        $stmt->close();
    }
}

// Stop execution time measurement
$end_time = microtime(true);
$metrics["execution_time"] = round($end_time - $start_time, 4);

// Log metrics to a file
$log_data = date("Y-m-d H:i:s") . " | Execution Time: {$metrics['execution_time']}s | Queries: {$metrics['query_count']} | Errors: {$metrics['error_count']} | Failures: " . implode(", ", $metrics["failure_type"]) . "\n";

// Ensure logging works
if (!file_put_contents($log_file, $log_data, FILE_APPEND)) {
    die("Logging failed! Check file permissions.");
}

// Close database connection
$conn->close();
?>
