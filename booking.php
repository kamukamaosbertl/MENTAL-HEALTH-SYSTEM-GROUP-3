<?php
session_start();
include 'includes/db_connection.php'; // Include the database connection

// Check if the user is logged in; if not, redirect to login page
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Process form data upon submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and trim input data
    $name = trim($_POST['name']);
    $telephone = trim($_POST['telephone']);
    $location = trim($_POST['location']);
    $problem = trim($_POST['problem']);
    $gender = trim($_POST['gender']);
    $user_id = $_SESSION['user_id'];
    $email = $_SESSION['email'];

    // Validate the required fields
    if (empty($name) || empty($telephone) || empty($location) || empty($problem) || empty($gender)) {
        echo "All fields are required.";
        exit();
    }

    // Handle file upload for the picture
    $picture = null;
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['picture']['name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        // Validate the file type
        if (in_array($_FILES['picture']['type'], $allowedTypes)) {
            if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile)) {
                $_SESSION['picture'] = $uploadFile;
                $picture = $uploadFile;
                echo "File has been uploaded successfully.";
            } else {
                echo "Error uploading the picture: " . $_FILES['picture']['error'];
                exit();
            }
        } else {
            echo "Invalid file type. Only JPEG, PNG, and GIF files are allowed.";
            exit();
        }
    }

    // Prepare the SQL query to insert the booking
    $stmt = $mysqli->prepare("INSERT INTO bookings (name, phone, location, problem, gender, picture) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die('Error preparing query: ' . $mysqli->error);
    }

    // Bind the parameters to the query
    $stmt->bind_param("ssssss", $name, $telephone, $location, $problem, $gender, $picture);

    // Execute the query
    if ($stmt->execute()) {
        // Send a confirmation email
        $subject = 'Session Booking Confirmation';
        $message = "Hello $name,\n\nYour session has been successfully booked!";
        
        // Validate the email format before sending
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            mail($email, $subject, $message);
        } else {
            echo "Invalid email address.";
            exit();
        }

        // Redirect to the confirmation page
        header("Location: confirmation.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
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
    <link rel="stylesheet" href="CSS/includes.css"> 
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
<
            <div class="form-group">
                <label for="picture">Upload Your Picture (optional)</label>
                <input type="file" name="picture" id="picture">
            </div>

            <button type="submit">Submit Booking</button>
        </form>
    </div>
</body>
</html>
