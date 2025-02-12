<footer>
    <p>&copy; 2024 Mental Health Support Service Platform. All rights reserved.</p>
    <div class="social-icons">
        <a href="#facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#twitter"><i class="fab fa-twitter"></i></a>
        <a href="#linkedin"><i class="fab fa-linkedin-in"></i></a>
                  <!-- PHP Logic for Login/Logout Links -->
                  <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">LOG OUT</a></li>
                <?php else: ?>
                    <li><a href="login.php">LOG IN</a></li>
                    <li><a href="signup.php">SIGN UP</a></li>
                <?php endif; ?>
    </div>
</footer>
