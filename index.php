<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENTAL HEALTH SUPPORT SERVICE PLATFOR</title>

    <!-- Link to External Stylesheets -->
    <link rel="stylesheet" href="CSS/include.css">
    <link rel="stylesheet" href="CSS/styles.css"> <!-- Page-specific styles -->
</head>
<body>

<?php include 'includes/header.php'; ?>

<main>
    <!-- Image Background Section -->
    <section class="image-background">
        <div class="text-animation" id="text-animation"></div>
    </section>

    <!-- JavaScript for Text Animation -->
    <script>
        const text = "This system empowers people to prioritize their mental health and create a supportive online community.";
        const textAnimation = document.getElementById("text-animation");
        let index = 0;

        function type() {
            if (index < text.length) {
                textAnimation.innerHTML += text.charAt(index);
                index++;
                setTimeout(type, 50); // Adjust typing speed (milliseconds)
            }
        }

        window.onload = type;
    </script>

    <!-- Video Section -->
    <section class="video-container">
        <h2>Watch This Explainer Video</h2>
        <video width="320" height="240" controls>
            <source src="video/MHARS PITCH DECK.mp4" type="video/mp4">
          
        </video>
    </section>

    <!-- Free Trial Section -->
    <section class="center-button">
        <h2>Start Your Free Trial</h2>
        <p>Get started today with a 7-day free trial and experience the benefits of our platform.</p>
        <a href="signup.php" class="btn">START YOUR FREE TRIAL</a>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <h2>What Our Users Are Saying</h2>
        <div class="testimonial-box" id="testimonial-1">
            <p>“Dr. Nabasa’s approach to trauma recovery has been life-changing for me.” - Susan B</p>
        </div>
        <div class="testimonial-box" id="testimonial-2">
            <p>“Dr. Kato helped our family navigate a very difficult time. His insights were invaluable.” - The Achieng Family</p>
        </div>
        <div class="testimonial-box" id="testimonial-3">
            <p>“Thanks to this platform, I’ve found a supportive community that really understands.” - Michael L</p>
        </div>
        <div class="testimonial-box" id="testimonial-4">
            <p>“This service has been an anchor during my mental health journey.” - Jessica M</p>
        </div>
        <div class="testimonial-box" id="testimonial-5">
            <p>“A fantastic resource that is invaluable for my mental health journey.” - Paul K</p>
        </div>
        <div class="testimonial-box" id="testimonial-6">
            <p>“The guidance and support offered here have been transformative.” - Hannah T</p>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

<script>
    // JavaScript to cycle through testimonials with hover effect
    document.addEventListener("DOMContentLoaded", function() {
        let testimonialIndex = 0;
        const testimonials = document.querySelectorAll(".testimonial-box");

        function showNextTestimonial() {
            testimonials.forEach((testimonial, index) => {
                testimonial.classList.remove("active");
            });
            testimonials[testimonialIndex].classList.add("active");
            testimonialIndex = (testimonialIndex + 1) % testimonials.length;
        }

       
        setInterval(showNextTestimonial, 2000);
        
        // Initialize with the first testimonial visible
        showNextTestimonial();
    });
</script>

</body>
</html>
