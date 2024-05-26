<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* General styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../image/UB-BACKGROUND.jpg'); /* Replace 'path_to_your_image.jpg' with the actual path to your image */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Navbar styles */
        header {
            background-color: #ffffff;
            color: #fff;
            padding: 10px 0;
            position: fixed; /* Fixed positioning */
            top: 0; /* Place the navbar at the top */
            width: 100%; /* Make the navbar span the entire width */
            z-index: 999; /* Ensure the navbar stays above other content */
        }

        .navbar {
            display: flex;
            justify-content: flex-start; /* Align items to the start */
            align-items: center;
            padding-left: 20px;
        }

        .navbar img {
            height: 50px; /* Adjust the height as needed */
            margin-right: 15px;
        }

        /* Wrapper styles */
        .wrapper {
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin-top: 80px; /* Adjust margin-top to center vertically */
        }

        /* Form styles */
        form {
            display: flex;
            flex-direction: column;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .input-box {
            margin-bottom: 15px;
            position: relative;
        }

        .input-box input {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        .input-box i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #ccc;
            font-size: 18px;
        }

        .input-box input:focus + i,
        .input-box input:valid + i {
            color: #999;
        }

        /* Role selection styles */
        .role {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .role label {
            margin-right: 10px;
        }

        /* Button styles */
        .btn {
            display: block;
            width: 100%;
            padding: 12px 0;
            background-color: #6b1500;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s, transform 0.2s;
            text-align: center;
        }
        .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }


        /* Login link styles */
        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            color: #671111;
            text-decoration: none;
        }

        /* Error message styles */
        .error-message {
            background-color: #f0ad4e;
            color: #fff;
            padding: 10px;
            border-radius: 3px;
            margin-top: 15px;
        }

        .error-message p {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar">
        <img src="../image/UB-Master-Logo.jpg" alt="University of Batangas Logo">
        <!-- You can add more navbar elements here if needed -->
    </nav>
</header>

<div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3>Admin Registration</h3>
        <div class="input-box">
            <input type="text" name="user_id" placeholder="User ID" required>
            <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
            <input type="text" name="name" placeholder="Name" required>
            <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
            <input type="password" name="password_1" placeholder="Password" required>
            <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="input-box">
            <input type="password" name="password_2" placeholder="Confirm Password" required>
            <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="role">
              <label for="role">Select Role:</label>
              <input type="radio" id="role-admin" name="role" value="admin" required>
              <label for="role-admin">Admin</label>
              <input type="radio" id="role-student" name="role" value="student" required>
              <label for="role-user">Student</label>
        </div>
        <button type="submit" class="btn" name="register_user">Register</button>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
        <?php if(isset($errors) && count($errors) > 0) { ?>
            <div class="error-message">
                <?php foreach ($errors as $error) { ?>
                    <p><?php echo $error; ?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </form>
</div>
</body>
</html>
