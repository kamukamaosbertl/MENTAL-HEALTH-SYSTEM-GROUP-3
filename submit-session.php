<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $telephone = $_POST['telephone'];
    $location = $_POST['location'];
    $problem = $_POST['problem'];
    $gender = $_POST['gender'];

    // Handle file upload
    if (isset($_FILES['picture'])) {
        $picture = $_FILES['picture'];
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($picture['name']);
        move_uploaded_file($picture['tmp_name'], $uploadFile);
    }

    // Email content
    $to = 'recipient@example.com';  
    $subject = 'Session Booking Confirmation';
    $message = "Hello $name,\n\nYour session has been successfully booked! A counselor will contact you soon.\n\nDetails:\n\nName: $name\nTelephone: $telephone\nLocation: $location\nProblem: $problem\nGender Preference: $gender\n\nThank you for booking with us.";

    // Send email
    mail($to, $subject, $message);

    // Display confirmation message
    echo "<script>document.querySelector('.confirmation-message').style.display = 'block';</script>";
}
?>
