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
    
    // Display success/error message
    echo "<script>alert('$response');</script>";
}
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
