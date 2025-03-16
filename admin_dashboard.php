<?php
session_start();
include('includes/db_connection.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize an empty array to store booking data
$booked_sessions = [];
$error_message = '';
$execution_times = [];
$failed_bookings = 0;
$total_bookings = 0;
$start_time = microtime(true);  // Start measuring total page load time

try {
    // Fetch all data directly from the bookings table
    $booked_sessions_query = "
        SELECT 
            booking_id, 
            name, 
            location, 
            phone, 
            email, 
            service_id, 
            booking_date, 
            problem, 
            gender, 
            picture 
        FROM bookings 
        ORDER BY booking_date DESC";
    
    // Measure query execution time
    $query_start_time = microtime(true);
    $booked_sessions_result = $conn->query($booked_sessions_query);
    $query_end_time = microtime(true);
    
    $query_execution_time = $query_end_time - $query_start_time;  // Query execution time
    
    $execution_times['query'] = $query_execution_time;
    
    // Check if the query was successful
    if (!$booked_sessions_result) {
        throw new Exception("Failed to retrieve booked sessions data. " . $conn->error);
    }

    // Fetch all rows as an associative array
    $booked_sessions = $booked_sessions_result->fetch_all(MYSQLI_ASSOC);

    // Count total bookings and failed bookings
    $total_bookings = count($booked_sessions);
    foreach ($booked_sessions as $session) {
        if (empty($session['booking_id'])) {
            $failed_bookings++;
        }
    }

} catch (Exception $e) {
    // Store the error message and track failed query
    $error_message = "Error: " . $e->getMessage();
    $failed_bookings++;
}

// Total execution time for the page
$end_time = microtime(true);
$total_execution_time = $end_time - $start_time;
$execution_times['total'] = $total_execution_time;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="CSS/admin.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="logout.php">Logout</a> <!-- Link to logout.php for clearing session -->
        </nav>
    </header>
    <main>
        <section>
            <h2>Booked Sessions</h2>
            
            <?php if ($error_message): ?>
                <!-- Display the error message -->
                <p class="error"><?php echo $error_message; ?></p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Service ID</th>
                            <th>Booking Date</th>
                            <th>Problem</th>
                            <th>Gender</th>
                            <th>Picture</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($booked_sessions as $session): ?>
                            <tr>
                                <td><?php echo $session['booking_id']; ?></td>
                                <td><?php echo $session['name']; ?></td>
                                <td><?php echo $session['location'] ?: 'No Location'; ?></td>
                                <td><?php echo $session['phone'] ?: 'No Phone'; ?></td>
                                <td><?php echo $session['email']; ?></td>
                                <td><?php echo $session['service_id'] ?: 'No Service'; ?></td>
                                <td><?php echo $session['booking_date']; ?></td>
                                <td><?php echo $session['problem']; ?></td>
                                <td><?php echo $session['gender']; ?></td>
                                <td>
                                    <?php if ($session['picture']): ?>
                                        <img src="<?php echo $session['picture']; ?>" alt="Picture" width="50">
                                    <?php else: ?>
                                        No Picture
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

        <section>
            <h2>User Management</h2>
            <a href="generate_report.php">Generate Reports</a>
            <!-- Additional actions to interact with users can go here -->
        </section>

        <!-- Display Performance Metrics -->
        <section>
            <h2>Performance Metrics</h2>
            <p><strong>Total Page Load Time:</strong> <?php echo round($execution_times['total'], 4); ?> seconds</p>
            <p><strong>Query Execution Time:</strong> <?php echo round($execution_times['query'], 4); ?> seconds</p>
            <p><strong>Total Bookings:</strong> <?php echo $total_bookings; ?></p>
            <p><strong>Failed Bookings:</strong> <?php echo $failed_bookings; ?></p>
        </section>
    </main>
</body>
</html>
