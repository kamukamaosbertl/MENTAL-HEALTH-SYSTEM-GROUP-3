<?php
// Your database credentials
$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$database = 'mental health'; // Your database name

// Create the connection
$conn = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
