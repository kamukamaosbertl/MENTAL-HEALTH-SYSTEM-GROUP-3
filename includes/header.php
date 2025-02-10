<header>
    <div class="container">
        <div class="logo">
            <h1>MENTAL HEALTH SUPPORT SYSTEM</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="services.php">SERVICES</a></li>
                <li><a href="plans.php">PLANS</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="community.php">COMMUNITY</a></li>
                <!-- PHP Logic for Login/Logout Links -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">LOG OUT</a></li>
                <?php else: ?>
                    <li><a href="login.php">LOG IN</a></li>
                    <li><a href="signup.php">SIGN UP</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<!-- Triangle Panel (placed below the header) -->
<div class="triangle-panel">
    <div class="panel-content">
        <h2>Welcome to Our Support System</h2>
        <p>Here to help you through tough times.</p>
    </div>
</div>
