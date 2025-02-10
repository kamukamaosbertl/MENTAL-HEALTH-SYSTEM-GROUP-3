<?php
include 'includes/header.php'; // Include header with navigation
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - Mental Health Support System</title>
    <link rel="stylesheet" href="CSS/include.css"> <!-- General styles -->
    <link rel="stylesheet" href="CSS/styles.css">  <!-- Page-specific styles -->
    <link rel="stylesheet" href="CSS/community.css">
</head>
<body>

    <main>
        <section class="community-section">
            <h2>Join Our Community</h2>
            <p>Connect with others who share similar experiences and gain support from a diverse community dedicated to mental well-being.</p>
            
            <div class="community-features">
                <div class="feature-card">
                    <h3>Support Groups</h3>
                    <p>Participate in virtual support groups facilitated by trained professionals where you can share your thoughts and feelings in a safe environment.</p>
                </div>
                <div class="feature-card">
                    <h3>Forums</h3>
                    <p>Engage in discussions with community members about various mental health topics, and find answers to your questions.</p>
                </div>
                <div class="feature-card">
                    <h3>Resources</h3>
                    <p>Access a variety of resources including articles, videos, and podcasts that promote mental health awareness and education.</p>
                </div>
            </div>
            
            <div class="community-signup">
                <h3>Get Involved!</h3>
                <p>Sign up today to become a part of our growing community. Together, we can make a difference.</p>
                <a href="community_signup_action.php" class="join-us-button">Join Us</a>
            </div>
        </section>
    </main>

<?php
include 'includes/footer.php'; // Include footer
?>
</body>
</html>
