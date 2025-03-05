<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/db_connection.php');

// Initialize metrics
$metrics = [
    "error_count" => 0,
    "query_count" => 0,
    "execution_time" => 0,
    "failure_type" => [],
    "validation_time" => 0,
    "db_insert_time" => 0,
    "session_time" => 0
];

// Ensure logs folder exists
$log_dir = 'logs';
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0775, true);
}

$log_file = "$log_dir/metrics.log";
if (!file_exists($log_file)) {
    file_put_contents($log_file, "Metrics Log Created: " . date("Y-m-d H:i:s") . "\n");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Input validation
    $validation_start = microtime(true);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        $metrics["error_count"]++;
        $metrics["failure_type"][] = "Invalid Email Format";
    } elseif (strlen($password) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters long.";
        $metrics["error_count"]++;
        $metrics["failure_type"][] = "Weak Password";
    } else {
        $validation_end = microtime(true);
        $metrics["validation_time"] = round($validation_end - $validation_start, 4);

        // Check if email exists
        $start_time = microtime(true);
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $metrics["query_count"]++;
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION['error'] = "Email is already registered.";
                $metrics["error_count"]++;
                $metrics["failure_type"][] = "Duplicate Email";
            } else {
                // Insert user
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (fullname, email, password_hash, role) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $name, $email, $password_hash, $role);

                if ($stmt->execute()) {
                    $_SESSION['success'] = "Registration successful! Redirecting to login page.";
                    header("Location: login.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Error saving your information. Please try again.";
                    $metrics["error_count"]++;
                    $metrics["failure_type"][] = "Database Insert Error";
                }
            }
            $stmt->close();
        } catch (Exception $e) {
            $_SESSION['error'] = "Database error: " . $e->getMessage();
            $metrics["error_count"]++;
            $metrics["failure_type"][] = "Database Exception";
        }

        $end_time = microtime(true);
        $metrics["execution_time"] = round($end_time - $start_time, 4);
    }

    // Log metrics
    $log_data = [
        "timestamp" => date("Y-m-d H:i:s"),
        "execution_time" => $metrics["execution_time"],
        "query_count" => $metrics["query_count"],
        "error_count" => $metrics["error_count"],
        "failure_types" => $metrics["failure_type"]
    ];
    file_put_contents($log_file, json_encode($log_data) . "\n", FILE_APPEND);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Mental Health Support System</title>
    <link rel="stylesheet" href="CSS/signup.css">
    <link rel="stylesheet" href="CSS/include.css">
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="form-main">
        <div class="signup-container">
            <h2>Sign Up</h2>
            <?php
            if (isset($_SESSION['error'])) {
                echo "<p class='error-message'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo "<p class='success-message'>" . $_SESSION['success'] . "</p>";
                unset($_SESSION['success']);
            }
            ?>
            <form method="POST" action="">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit">Sign Up</button>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>