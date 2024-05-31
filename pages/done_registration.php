<?php
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // Your database password
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === FALSE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create users table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(50) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user_id']);
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .logout {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
            font-size: 20px;
            color: #666;
            transition: color 0.3s ease;
        }
        .logout:hover {
            color: #333;
        }
        .welcome {
            text-align: center;
            margin-bottom: 30px;
        }
        .welcome h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .content {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logout" onclick="location.href='http://localhost/Inventory_System-MAIN/index.html'">
        <i class='bx bx-log-out-circle'></i> Proceed to Home
    </div>
    <div class="welcome">
        <h2>UBLC Engineering Inventory Management System</h2>
        <p>Hi <?php echo $_SESSION['user_id']; ?></p>
    </div>
    <div class="content">
        <p class="text-center">Registration successful! You can now log in.</p>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?php echo $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
