<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "login";

    // Create connection
    $db = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($db->connect_error) {
        session_start();

// Enable error reporting
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            // Database connection details
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "login";

            // Create connection
            $db = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($db->connect_error) {
                die("Connection failed: " . $db->connect_error);
            }

            // Update user status to 'offline'
            $update_status_query = "UPDATE users SET status='offline' WHERE user_id='$user_id'";
            if (!mysqli_query($db, $update_status_query)) {
                die("Error updating status: " . mysqli_error($db));
            }

            // Destroy the session
            session_unset();
            session_destroy();

            // Redirect to login page
            header('Location: http://localhost/Inventory_System-MAIN/index.html');
            exit();
        } else {
            // If no user_id is found in session, redirect to login page
            header('Location: http://localhost/Inventory_System-MAIN/index.html');
            exit();
        }


        die("Connection failed: " . $db->connect_error);
    }

    // Update user status to 'offline'
    $update_status_query = "UPDATE users SET status='offline' WHERE user_id='$user_id'";
    mysqli_query($db, $update_status_query);

    // Destroy the session
    session_unset();
    session_destroy();

    // Redirect to login page
    header('Location: http://localhost/Inventory_System-MAIN/index.html');
    exit();
}
?>
