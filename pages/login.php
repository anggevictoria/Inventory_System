<?php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create connection
$db = mysqli_connect($servername, $username, $password);

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!mysqli_query($db, $sql)) {
    die("Error creating database: " . mysqli_error($db));
}

// Select the database
mysqli_select_db($db, $dbname);

// Create users table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    name VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL,
    status VARCHAR(10) DEFAULT 'offline' NOT NULL
)";
if (!mysqli_query($db, $sql)) {
    die("Error creating table: " . mysqli_error($db));
}

// Initialize errors array
$errors = array();

// LOGIN USER
if (isset($_POST['login_user'])) {
    $user_id = mysqli_real_escape_string($db, $_POST['user_id']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($user_id)) {
        array_push($errors, "User ID is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE user_id='$user_id'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
            $row = mysqli_fetch_assoc($results);

            if (password_verify($password, $row['password'])) { // Verify with hashed password
                $_SESSION['user_id'] = $user_id;
                $role = $row['role'];  // Assuming a role field exists

                if ($role === "admin") {
                    $_SESSION['success'] = "Welcome Admin, you are now logged in";
                    header('location: homepage_admin.php');  // Redirect to admin homepage
                } else {
                    $_SESSION['success'] = "You are now logged in";
                    header('location: homepage_student.php');  // Redirect to student homepage
                }
                exit();
            } else {
                array_push($errors, "Wrong User ID/password combination");
            }
        } else {
            array_push($errors, "Wrong User ID/password combination");
        }
    }
}

?>