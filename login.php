<?php
// Start the session securely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
include 'includes/db_connection.php';

// Initialize metrics
$metrics = [
    "error_count" => 0,
    "query_count" => 0,
    "execution_time" => 0,
    "failure_type" => [],
    "validation_time" => 0,
    "db_query_time" => 0,
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

// Initialize a variable to hold error messages
$errorMessage = "";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve the email, password, and role from the POST request
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Input validation
    $validation_start = microtime(true);
    if (!empty($email) && !empty($password) && !empty($role)) {
        $validation_end = microtime(true);
        $metrics["validation_time"] = round($validation_end - $validation_start, 4);

        // Database query execution
        $query_start = microtime(true);
        $query = "SELECT * FROM users WHERE email = ? AND role = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ss", $email, $role);
            $stmt->execute();
            $metrics["query_count"]++;
            $result = $stmt->get_result();
            $query_end = microtime(true);
            $metrics["db_query_time"] = round($query_end - $query_start, 4);

            // Check if a user exists with the provided email and role
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Verify the password against the hashed password in the database
                if (password_verify($password, $user['password_hash'])) {
                    // Set session variables for the logged-in user
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect to the appropriate page based on role
                    if ($role === 'admin') {
                        header("Location: admin_dashboard.php");
                    } else {
                        header("Location: services.php");
                    }
                    exit;
                } else {
                    $errorMessage = "Invalid password. Please try again.";
                    $metrics["error_count"]++;
                    $metrics["failure_type"][] = "Invalid Password";
                }
            } else {
                $errorMessage = "No account found with that email and role.";
                $metrics["error_count"]++;
                $metrics["failure_type"][] = "Account Not Found";
            }

            $stmt->close();
        } else {
            $errorMessage = "Error preparing statement. Please try again later.";
            $metrics["error_count"]++;
            $metrics["failure_type"][] = "Database Error";
        }
    } else {
        $errorMessage = "Please enter your email, password, and role.";
        $metrics["error_count"]++;
        $metrics["failure_type"][] = "Missing Input";
    }

    // Log metrics
    $log_data = [
        "timestamp" => date("Y-m-d H:i:s"),
        "execution_time" => $metrics["execution_time"],
        "query_count" => $metrics["query_count"],
        "error_count" => $metrics["error_count"],
        "failure_types" => $metrics["failure_type"],
        "validation_time" => $metrics["validation_time"],
        "db_query_time" => $metrics["db_query_time"]
    ];
    file_put_contents($log_file, json_encode($log_data) . "\n", FILE_APPEND);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mental Health Support System</title>
    <link rel="stylesheet" href="CSS/login.css">
    <link rel="stylesheet" href="CSS/include.css">
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <div class="login-container">
            <h2>Login</h2>
            
            <?php if (!empty($errorMessage)): ?>
                <p class="error-message"><?php echo htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>
            
            <form method="POST" action="">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>" required>

                <label for="role">Login as</label>
                <select id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="user" <?php echo isset($role) && $role == 'user' ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo isset($role) && $role == 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>

                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>