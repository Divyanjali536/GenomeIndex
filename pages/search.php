<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once __DIR__ . '/../includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Genes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f7f8fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Back button */
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

        /* Top right buttons */
        .top-right {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .top-btn {
            background-color: transparent;
            border: 2px solid #006d77;
            color: #006d77;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .top-btn:hover {
            background-color: #006d77;
            color: white;
        }

        /* Profile icon */
        .profile-icon {
            display: inline-block;
            background-color: transparent;
            border: 2px solid #006d77;
            padding: 6px;
            border-radius: 50%;
            text-decoration: none;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .profile-icon:hover {
            background-color: #006d77;
            border-color: #004f52;
        }
        .profile-icon svg {
            fill: #006d77;
            width: 20px;
            height: 20px;
            transition: fill 0.3s ease;
        }
        .profile-icon:hover svg {
            fill: white;
        }

        /* Search form */
        .search-container {
            margin-top: 150px;
            text-align: center;
        }

        .search-container input[type="text"] {
            padding: 12px;
            width: 350px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .search-container button {
            padding: 12px 18px;
            margin-left: 10px;
            background-color: transparent;
            border: 2px solid #006d77;
            color: #006d77;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .search-container button:hover {
            background-color: #006d77;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Back Button -->
    <a href="../index.php" class="back-btn">← Back</a>

    <!-- Top Right Buttons -->
    <div class="top-right">
        <a href="upload_gene.php" class="top-btn">Upload New Gene</a>
        <a href="tools.php" class="top-btn">Tools</a> <!-- New Tools Button -->
        <a href="profile.php" class="profile-icon" title="Profile">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2V19.2c0-3.2-6.4-4.8-9.6-4.8z"/>
            </svg>
        </a>
    </div>

    <!-- Search Box -->
    <div class="search-container">
        <h2>Search for a Gene</h2>
        <form action="search_results.php" method="GET">
            <input type="text" name="query" placeholder="Enter Gene or ID">
            <button type="submit">Search</button>
        </form>
    </div>

</body>
</html>
