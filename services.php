<?php

session_start();  // Call session_start() only once, at the beginning of the script.
include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/include.css">
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="stylesheet" href="CSS/services.css">
    <?php

if (isset($_SESSION['user_id'])) {
    echo '<link rel="stylesheet" href="CSS/reports.css">';
}
?>

    <script src="script.js" defer></script>
</head>
<body>

<h1 id="typing-heading"></h1>

<section>
    <!-- Display User Reports in a Table -->
    <?php
    // Debug: Check the contents of the 'user_reports' session variable
    // var_dump($_SESSION['user_reports']);  // This will show the structure of the session data

    if (isset($_SESSION['user_reports']) && !empty($_SESSION['user_reports'])) {
        echo "<h2>Your Reports</h2>";
        echo "<table border='1'>
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Content</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($_SESSION['user_reports'] as $report) {
            // Safely access the 'report_content' and 'created_at' values with a fallback if missing
            $report_content = isset($report['report_content']) ? htmlspecialchars($report['report_content']) : 'No content available';
            $created_at = isset($report['created_at']) ? htmlspecialchars($report['created_at']) : 'No date available';

            echo "<tr>
            <td>" . htmlspecialchars($report['report_id']) . "</td>
            <td>" . $report_content . "</td>
            <td>" . $created_at . "</td>
          </tr>";
}
echo "</tbody></table>";

// Add Download Button
echo "<a href='download_report.php' class='download-button'>Download Reports</a>";
} else {
echo "<p>No reports available.</p>";
}
?>


    <h2>Explore Our Services</h2>
    <div class="services-container">
        <!-- Service 1 -->
        <div class="service-box">
            <img src="./images/one on one.svg" alt="Couple Therapy" class="service-image">
            <h3><a href="counseling.php">One-on-One Counseling</a></h3>
            <p class="service-description">Our personalized counseling sessions provide a safe, confidential space to explore your emotions, build resilience, and gain insights to help you thrive.</p>
            <button class="view-more-btn" onclick="toggleWebView('counseling-webview-overlay')">Learn More</button>
        </div>
        <div id="counseling-webview-overlay" class="webview-overlay">
            <div class="webview-modal">
                <button class="close-btn" onclick="toggleWebView('counseling-webview-overlay')">Close</button>
                <iframe src="https://www.csuci.edu/caps/individual-counseling.htm" frameborder="0"></iframe>
            </div>
        </div>

        <!-- Service 2 -->
        <div class="service-box">
            <img src="./images/telethepy.svg" alt="Teletherapy" class="service-image">
            <h3><a href="teletherapy.php">Teletherapy</a></h3>
            <p class="service-description">Accessible therapy sessions from the comfort of your home. Engage with certified professionals online and receive guidance tailored to your needs.</p>
            <button class="view-more-btn" onclick="toggleWebView('teletherapy-webview-overlay')">Learn More</button>
        </div>
        <div id="teletherapy-webview-overlay" class="webview-overlay">
            <div class="webview-modal">
                <button class="close-btn" onclick="toggleWebView('teletherapy-webview-overlay')">Close</button>
                <iframe src="https://www.psychology.org/resources/how-does-teletherapy-work/#:~:text=Teletherapy%20offers%20treatment%20provided%20by,sessions%2C%20just%20from%20a%20distance." frameborder="0"></iframe>
            </div>
        </div>

        <!-- Service 3 -->
        <div class="service-box">
            <img src="./images/group therapy 2.svg" alt="Group Therapy" class="service-image">
            <h3><a href="support-groups.php">Group Therapy</a></h3>
            <p class="service-description">Join a supportive group where individuals share similar experiences, guided by a licensed therapist, to foster growth, empathy, and mutual support.</p>
            <button class="view-more-btn" onclick="toggleWebView('group-therapy-webview-overlay')">Learn More</button>
        </div>
        <div id="group-therapy-webview-overlay" class="webview-overlay">
            <div class="webview-modal">
                <button class="close-btn" onclick="toggleWebView('group-therapy-webview-overlay')">Close</button>
                <iframe src="https://www.ncbi.nlm.nih.gov/books/NBK549812/" frameborder="0"></iframe>
            </div>
        </div>

        <!-- Service 4 -->
        <div class="service-box">
            <img src="./images/couple therapy.svg" alt="Family Therapy" class="service-image">
            <h3><a href="family-therapy.php">Family Therapy</a></h3>
            <p class="service-description">Improve family dynamics and communication through therapeutic guidance that helps family members understand and support each other.</p>
            <button class="view-more-btn" onclick="toggleWebView('family-therapy-webview-overlay')">Learn More</button>
        </div>
        <div id="family-therapy-webview-overlay" class="webview-overlay">
            <div class="webview-modal">
                <button class="close-btn" onclick="toggleWebView('family-therapy-webview-overlay')">Close</button>
                <iframe src="https://www.medicalnewstoday.com/articles/family-counseling" frameborder="0"></iframe>
            </div>
        </div>

        <!-- Service 5: Mental Health Resources -->
        <div class="service-box">
            <img src="./images/video.svg" alt="Mental Health Resources" class="service-image">
            <h3><a href="resources.php">Mental Health Resources</a></h3>
            <p class="service-description">Explore a variety of resources including videos, music, podcasts, quotes, and more to support your mental health journey.</p>
            <button class="view-more-btn" onclick="toggleWebView('mental-health-resources-webview-overlay')">Learn More</button>
        </div>
        <div id="mental-health-resources-webview-overlay" class="webview-overlay">
            <div class="webview-modal">
                <button class="close-btn" onclick="toggleWebView('mental-health-resources-webview-overlay')">Close</button>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/BpzVvUGfJeA?si=F-QXUPSOdtLsCue0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

            </div>
        </div>

    </div>

</section>

<script>
    // Toggle the WebView overlay display with fade-in effect
    function toggleWebView(id) {
        const overlay = document.getElementById(id);
        overlay.style.display = overlay.style.display === 'none' || !overlay.style.display ? 'flex' : 'none';
    }
</script>

</body>
</html>

<?php
include 'includes/footer.php';
?>
