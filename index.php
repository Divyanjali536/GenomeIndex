<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Genome Index</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Top bar with profile icon -->
    <div class="top-bar">
        <a class="profile-icon" href="pages/profile.php" 
           title="<?php 
                if ($username) {
                    echo 'Logged in as: ' . htmlspecialchars($username);
                } else {
                    echo 'Login or Sign Up';
                }
           ?>">
            <svg xmlns="http://www.w3.org/2000/svg" height="22" width="22" fill="white" viewBox="0 0 448 512">
                <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm89.6 32h-11.8c-22.4 10.3-47.3 16-73.8 16s-51.4-5.7-73.8-16h-11.8C66.1 288 0 354.1 0 437.5 0 469.3 26.7 496 58.5 496h331c31.8 0 58.5-26.7 58.5-58.5 0-83.4-66.1-149.5-146.4-149.5z"/>
            </svg>
        </a>
    </div>

    <!-- Main centered content -->
    <div class="main-content">
        <h1>Welcome to Genome Index</h1>
        <p>Your one-stop gene search tool.</p>

        <?php if (!$username): ?>
            <!-- Show Sign Up & Login if NOT logged in -->
            <div class="button-row">
                <a class="button-link" href="pages/signup.php">Sign Up</a>
                <a class="button-link" href="pages/login.php">Login</a>
            </div>
        <?php else: ?>
            <!-- Show Search button if logged in -->
            <div class="button-row">
                <a class="button-link primary-action" href="pages/search.php">🔍 Go to Search</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
