<?php
// Start the session to manage user signup sessions
session_start();
// Include the database connection file
include('includes/db_connection.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize user input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']); // Capture the role

    // Perform simple validation on email and password
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format."; // Set error for invalid email
    } elseif (strlen($password) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters long."; // Set error for short password
    } else {
        // Check if the email already exists in the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) { // If email already exists
            $_SESSION['error'] = "Email is already registered.";
        } else {
            // Hash password and insert user into database
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (fullname, email, password_hash, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $password_hash, $role);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Registration successful! Redirecting to login page.";
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['error'] = "Error saving your information. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Mental Health Support System</title>
    <link rel="stylesheet" href="CSS/signup.css"> <!-- General styles -->
    <link rel="stylesheet" href="CSS/include.css"> <!-- General styles -->
    <link rel="stylesheet" href="CSS/styles.css"> <!-- Specific styles -->
</head>
<body>
    <?php include 'includes/header.php'; ?> <!-- Include the header -->

    <main class="form-main"> 
        <div class="signup-container">
            <h2>Sign Up</h2>

            <?php
            // Display error/success message if set
            if (isset($_SESSION['error'])) {
                echo "<p class='error-message'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo "<p class='success-message'>" . $_SESSION['success'] . "</p>";
                unset($_SESSION['success']);
            }
            ?>

            <!-- Registration form -->
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
