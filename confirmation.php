<?php
session_start();
include 'includes/db_connection.php';

// Retrieve session data if available
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$telephone = isset($_SESSION['telephone']) ? $_SESSION['telephone'] : '';
$location = isset($_SESSION['location']) ? $_SESSION['location'] : '';
$problem = isset($_SESSION['problem']) ? $_SESSION['problem'] : '';
$gender = isset($_SESSION['gender']) ? $_SESSION['gender'] : '';
$picture = isset($_SESSION['picture']) ? $_SESSION['picture'] : '';

// If session data is missing, redirect to the booking page
if (empty($name) || empty($telephone) || empty($location)) {
    echo "Session data is missing.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Booking Confirmed</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <h1>Session Booking Confirmed</h1>
    <p>Thank you for booking a session. Here are the details:</p>

    <ul>
        <li><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></li>
        <li><strong>Telephone:</strong> <?php echo htmlspecialchars($telephone); ?></li>
        <li><strong>Location:</strong> <?php echo htmlspecialchars($location); ?></li>
        <li><strong>Problem:</strong> <?php echo htmlspecialchars($problem); ?></li>
        <li><strong>Gender Preference:</strong> <?php echo htmlspecialchars($gender); ?></li>
    </ul>

    <?php if ($picture): ?>
        <h3>Uploaded Picture (ID):</h3>
        <img src="<?php echo htmlspecialchars($picture); ?>" alt="User ID Picture" style="max-width: 200px;">
    <?php endif; ?>

    <p>We have sent a confirmation email to your registered email address. A counselor will contact you soon.</p>
</body>
</html>
