<?php
function validateBookingInput($name, $telephone, $location, $problem, $gender, $email) {
    return !empty($name) && !empty($telephone) && !empty($location) && !empty($problem) && !empty($gender) &&
           filter_var($email, FILTER_VALIDATE_EMAIL);
}

function processFileUpload($file) {
    $uploadDir = 'uploads/';
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($file['type'], $allowedTypes) || $file['size'] > 2 * 1024 * 1024) {
        return null; // Invalid type or file too large
    }

    $uniqueFileName = $uploadDir . uniqid() . "-" . basename($file['name']);
    return move_uploaded_file($file['tmp_name'], $uniqueFileName) ? $uniqueFileName : null;
}

function insertBooking($conn, $name, $telephone, $location, $problem, $gender, $picture) {
    $stmt = $conn->prepare("INSERT INTO bookings (name, phone, location, problem, gender, picture, status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("ssssss", $name, $telephone, $location, $problem, $gender, $picture);
    return $stmt->execute();
}

function sendConfirmationEmail($email, $name) {
    $subject = "Session Booking Confirmation";
    $message = "Hello $name,\n\nYour session has been successfully booked!";
    mail($email, $subject, $message);
}

function bookSession($conn, $data, $file) {
    $name = trim($data['name']);
    $telephone = trim($data['telephone']);
    $location = trim($data['location']);
    $problem = trim($data['problem']);
    $gender = trim($data['gender']);
    $email = $_SESSION['email'];

    if (!validateBookingInput($name, $telephone, $location, $problem, $gender, $email)) {
        return "Invalid input provided.";
    }

    $picture = ($file && $file['error'] == 0) ? processFileUpload($file) : null;

    if (!insertBooking($conn, $name, $telephone, $location, $problem, $gender, $picture)) {
        return "Database error. Please try again.";
    }

    sendConfirmationEmail($email, $name);
    return "Booking successful!";
}
?>
