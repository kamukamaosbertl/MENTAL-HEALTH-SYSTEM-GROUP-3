<?php
session_start(); // Start the session

// Include the database connection file
include('includes/db_connection.php');

// Check if the user is logged in (for demonstration purposes, we will not implement actual authentication here)
if (!isset($_SESSION['user_id'])) {
    header("Location: community_signup.php"); // Redirect to signup if not logged in
    exit();
}

// Fetch community details (dummy data for now)
$community_details = [
    ['title' => 'Mental Health Awareness', 'description' => 'Join us in raising awareness for mental health issues.'],
    ['title' => 'Support Groups', 'description' => 'Connect with others who share similar experiences.'],
    ['title' => 'Workshops & Events', 'description' => 'Participate in workshops that promote mental well-being.'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Dashboard - Mental Health Support System</title>
    <link rel="stylesheet" href="CSS/include.css"> <!-- General styles -->
    <link rel="stylesheet" href="CSS/styles.css"> <!-- Link to community dashboard specific styles -->
</head>
<body>
    <?php include 'includes/header.php'; ?> <!-- Include the header component -->

    <main>
        <h2>Welcome to the Community Dashboard!</h2>
        <p>Here are some of the community features:</p>
        <div class="community-features">
            <?php foreach ($community_details as $feature): ?>
                <div class="feature-card">
                    <h3><?php echo $feature['title']; ?></h3>
                    <p><?php echo $feature['description']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?> <!-- Include the footer component -->
</body>
</html>
