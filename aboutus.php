<?php
include 'includes/header.php'; // Include header with navigation
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Mental Health Support System</title>

    <!-- Styles -->
    <link rel="stylesheet" href="CSS/include.css">
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="stylesheet" href="CSS/about.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .about-container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            color: #2c3e50;
        }

        .team-section,
        .testimonials,
        .contact-section {
            margin-top: 40px;
        }

        .team-member {
            display: inline-block;
            width: 30%;
            margin: 10px;
            padding: 10px;
            background: #eaf2f8;
            border-radius: 8px;
        }

        .team-member img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .testimonial {
            background: #d5f5e3;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
        }
    </style>

</head>

<body>

    <section class="about-section">
        <div class="about-container">
            <h2>About Us</h2>
            <p>We are dedicated to providing mental health support through innovative counseling services and a
                supportive community.</p>

            <!-- Mission -->
            <div class="mission-section">
                <h3>Our Mission</h3>
                <p>To promote mental well-being and provide accessible, compassionate, and professional counseling
                    services to individuals in need.</p>
            </div>

            <!-- Team Section -->
            <div class="team-section">
                <h3>Meet Our Team</h3>
                <div class="team-member">

                    <h4>Dr. REIGNS GERS</h4>
                    <p>Lead Psychologist</p>
                </div>
                <div class="team-member">

                    <h4>FR.OSBERT</h4>
                    <p>Therapist & Support Specialist</p>
                </div>
            </div>

            <!-- Testimonials -->
            <div class="testimonials">
                <h3>What Our Clients Say</h3>
                <div class="testimonial">
                    <p>"This platform changed my life! The counselors are truly amazing."</p>
                    <strong>- Anonymous</strong>
                </div>
                <div class="testimonial">
                    <p>"A safe space to share and heal. Highly recommended!"</p>
                    <strong>- Alex R.</strong>
                </div>
            </div>

            <!-- Contact -->
            <div class="contact-section">
                <h3>Contact Us</h3>
                <p>Email: support@mentalhealth.com</p>
                <p>Phone: +123 456 7890</p>
            </div>
        </div>
    </section>

    <?php
    include 'includes/footer.php'; // Include footer
    ?>
</body>

</html>