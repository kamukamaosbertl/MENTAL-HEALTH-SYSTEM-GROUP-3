<?php
// Start the session
session_start();
// Destroy the session to log the user out
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="CSS/logout.css">
</head>
<body>
    <div class="logout-message">
        <h2>You have successfully logged out!</h2>
        <p>Redirecting you to the home page...</p>
    </div>
    <script>
        // Redirect to the home page after 3 seconds
        setTimeout(function() {
            window.location.href = "index.php";
        }, 3000);
    </script>
</body>
</html>
