<?php
// Start the session to manage user login sessions
session_start();

// Include the database connection file
include 'includes/db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Fetch the reports for the logged-in user
$stmt = $conn->prepare("SELECT * FROM users_reports WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$reportsResult = $stmt->get_result();
$reports = $reportsResult->fetch_all(MYSQLI_ASSOC);

$stmt->close(); // Close the statement
$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reports</title>
    <link rel="stylesheet" href="CSS/include.css"> <!-- General styles -->
    <link rel="stylesheet" href="CSS/styles.css">  <!-- Reports page-specific styles -->
    <link rel="stylesheet" href="CSS/reports.css"> <!-- Link to reports-specific styles -->
</head>
<body>
    <?php include 'includes/header.php'; ?> <!-- Include the header component -->

    <main>
        <div class="reports-container">
            <h2>Your Reports</h2>
            <?php if (empty($reports)): ?>
                <p>No reports found.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($reports as $report): ?>
                        <li class="report">
                            <p>Report ID: <?php echo $report['report_id']; ?></p>
                            <p>Content: <?php echo htmlspecialchars($report['report_content']); ?></p>
                            <p class="date">Date: <?php echo $report['created_at']; ?></p>
                            <a href="download_report.php?id=<?php echo $report['report_id']; ?>" class="download-button">Download Report</a> <!-- Download button -->
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?> <!-- Include the footer component -->
</body>
</html>
