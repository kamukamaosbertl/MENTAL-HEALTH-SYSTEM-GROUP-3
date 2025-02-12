<?php
session_start(); // Start the session to manage user signup sessions

// Include the database connection file
include('includes/db_connection.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize user input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']); // Collect the selected role

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

        // If the email is already registered
        if ($result->num_rows > 0) {
            $_SESSION['error'] = "Email is already registered in the community.";
        } else {
            // Hash the password for security
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the users table
            $stmt_id = $conn->prepare("INSERT INTO users (fullname, email, password_hash) VALUES (?, ?, ?)");
            $stmt_id->bind_param("sss", $name, $email, $password_hash);

            if ($stmt_id->execute()) {
                $user_id = $stmt_id->insert_id; // Get the last inserted user ID

                // Now insert the new community member
                $stmt = $conn->prepare("INSERT INTO community_members (user_id, role) VALUES (?, ?)");
                $stmt->bind_param("is", $user_id, $role);
                if ($stmt->execute()) {
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['success'] = "Registration successful! Redirecting to community dashboard.";
                    header("Location: community_dashboard.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Error saving your information: " . $stmt->error;
                }
            } else {
                $_SESSION['error'] = "Error saving your information: " . $stmt_id->error;
            }

            // Close the statement for inserting the user
            $stmt_id->close();
        }

        // Close the statement for checking existing email
        $stmt->close();
    }
}

// Close the database connection
$conn->close();

// Redirect back to signup page if there was an error
if (!isset($_SESSION['success'])) {
    header("Location: community_signup.php");
    exit();
}
?>
