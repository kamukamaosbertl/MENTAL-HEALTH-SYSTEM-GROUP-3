<?php
include 'includes/header.php'; // Include header with navigation
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One-on-One Counseling</title>
    <link rel="stylesheet" href="CSS/counseling.css">
    <link rel="stylesheet" href="CSS/include.css"> <!-- General styles for shared components -->
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>

    <main>
        <section class="service-description">
            <div class="counseling-content">
                <img src="./images/one on one.svg" alt="Counseling Image" class="counseling-image">
                <p class="counseling-text">This service provides personalized counseling sessions in a safe, confidential environment to explore emotions and build resilience.</p>
                <a href="booking.php" class="book-now-btn">Book Now</a>
            </div>
        </section>
    </main>

    <?php
    // Function to calculate cyclomatic complexity
    function calculateCyclomaticComplexity($code) {
        $decisionPoints = preg_match_all('/\b(if|else if|for|while|case|catch)\b/', $code, $matches);
        return 1 + $decisionPoints;
    }

    // Function to generate a simple control flow graph (CFG) representation
    function generateCFG($code) {
        $lines = explode("\n", $code);
        $graph = [];
        
        foreach ($lines as $index => $line) {
            $line = trim($line);
            if (preg_match('/\b(if|else if|for|while|switch|case)\b/', $line)) {
                $graph[] = "Node $index: Decision point ($line)";
            } else {
                $graph[] = "Node $index: Sequential ($line)";
            }
        }
        
        return $graph;
    }

    // Load and analyze the current file
    $codeContent = file_get_contents(__FILE__);
    $cyclomaticComplexity = calculateCyclomaticComplexity($codeContent);
    $cfg = generateCFG($codeContent);
    ?>

    <div class="metrics-container">
        <h2>Complexity Metrics</h2>
        <p><strong>Cyclomatic Complexity:</strong> <?php echo $cyclomaticComplexity; ?></p>
        <h3>Control Flow Graph (CFG)</h3>
        <pre><?php echo implode("\n", $cfg); ?></pre>
    </div>

<?php
include 'includes/footer.php'; // Include footer
?>
</body>
</html>
