<?php
session_start();

// Database connection
$servername = "localhost";
$dbusername = "root"; // default for XAMPP
$dbpassword = "";     // default for XAMPP
$dbname = "gene_db";  // your database name

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";
$success_message = "";

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if username already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $error_message = "Username already taken. Please choose another.";
    } else {
        // Insert new user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $success_message = "Signup successful! You can now log in.";
        } else {
            $error_message = "Error: Could not sign up.";
        }
        $stmt->close();
    }
    $check_stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="signup-container">
    <h2>Sign Up</h2>

    <?php if (!empty($error_message)) { ?>
        <p style="color:red;"><?php echo $error_message; ?></p>
    <?php } ?>
    <?php if (!empty($success_message)) { ?>
        <p style="color:green;"><?php echo $success_message; ?></p>
    <?php } ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Sign Up">
    </form>
</div>

</body>
</html>
