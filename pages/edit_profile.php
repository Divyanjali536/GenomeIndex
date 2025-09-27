<?php
session_start();

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "gene_db";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$current_username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);
    $new_password = $_POST['password'];

    $error_message = "";
    $success_message = "";

    // Update username if changed and not taken
    if ($new_username !== $current_username) {
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check_stmt->bind_param("s", $new_username);
        $check_stmt->execute();
        $check_stmt->store_result();
        if ($check_stmt->num_rows > 0) {
            $error_message = "Username already taken. Choose another.";
        } else {
            $stmt = $conn->prepare("UPDATE users SET username = ? WHERE username = ?");
            $stmt->bind_param("ss", $new_username, $current_username);
            $stmt->execute();
            $_SESSION['username'] = $new_username;
            $current_username = $new_username;
            $stmt->close();
        }
        $check_stmt->close();
    }

    // Update email
    if (empty($error_message)) {
        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE username = ?");
        $stmt->bind_param("ss", $new_email, $current_username);
        $stmt->execute();
        $stmt->close();
    }

    // Update password if provided
    if (!empty($new_password) && empty($error_message)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $hashed_password, $current_username);
        $stmt->execute();
        $stmt->close();
    }

    if (empty($error_message)) {
        $success_message = "Profile updated successfully!";
    }
}

// Fetch updated data
$query = "SELECT username, email FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $current_username);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .edit-profile-container {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.06);
            text-align: center;
            width: 380px;
        }
        .top-bar {
            position: absolute;
            top: 15px;
            left: 20px;
        }
        .button-row {
            display: flex;
            gap: 18px;
            justify-content: center;
            margin-top: 20px;
        }
        .success-message { color: green; margin-bottom: 15px; }
        .error-message { color: red; margin-bottom: 15px; }
        input[type=text], input[type=email], input[type=password] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type=submit] {
            background-color: #006d77;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type=submit]:hover {
            background-color: #004f52;
        }
        .button-link {
            text-decoration: none;
            color: #006d77;
            border: 2px solid #006d77;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        .button-link:hover {
            background-color: #006d77;
            color: white;
        }
    </style>
</head>
<body>

<div class="top-bar">
    <a href="profile.php" class="button-link">← Back</a>
</div>

<div class="edit-profile-container">
    <h2>Edit Profile</h2>
    <?php if(!empty($success_message)) echo "<p class='success-message'>$success_message</p>"; ?>
    <?php if(!empty($error_message)) echo "<p class='error-message'>$error_message</p>"; ?>

    <form method="POST">
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" placeholder="Username" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Email" required>
        <input type="password" name="password" placeholder="New Password (leave blank to keep current)">
        <div class="button-row">
            <input type="submit" value="Update">
        </div>
    </form>
</div>

</body>
</html>
