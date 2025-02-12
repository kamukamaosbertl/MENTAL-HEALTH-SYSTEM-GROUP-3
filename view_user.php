<?php
session_start();
include('includes/db_connection.php');

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ensure the user_id is provided and is valid
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    die("Invalid User ID.");
}

// Prepare and execute query to retrieve user information based on user_id
$user_query = $conn->prepare("SELECT * FROM users WHERE id = ?");
if ($user_query === false) {
    die('Error preparing statement: ' . $conn->error);
}

$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();

// Check if a user is found
if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
} else {
    die("User not found.");
}

// Close the statement
$user_query->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User</title>
    <link rel="stylesheet" href="CSS/admin.css">
</head>
<body>
    <header>
        <h1>User Information</h1>
        <nav>
            <a href="admin_dashboard.php">Back to Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <section>
            <h2>User Details</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['fullname']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Registered Date:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>
        </section>
    </main>
</body>
</html>
