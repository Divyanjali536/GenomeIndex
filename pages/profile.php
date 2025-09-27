<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Center container vertically and horizontally */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        /* Back button at the top left */
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            background-color: transparent;
            border: 2px solid #006d77;
            color: #006d77;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background-color: #006d77;
            color: white;
        }

        /* Profile content */
        .profile-container {
            text-align: center;
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.06);
            width: 380px;
        }

        /* Button row */
        .button-row {
            margin-top: 20px;
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .button-link {
            background-color: transparent;
            border: 2px solid #006d77;
            color: #006d77;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .button-link:hover {
            background-color: #006d77;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Back button -->
    <a href="../index.php" class="back-btn">← Back</a>

    <div class="profile-container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>This is your profile page.</p>

        <div class="button-row">
            <a href="edit_profile.php" class="button-link">Edit Profile</a>
            <a href="logout.php" class="button-link">Logout</a>
        </div>
    </div>

</body>
</html>
