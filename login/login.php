<?php
session_start();
include "logout.php";

// Redirect to homepage_student if user is already logged in
if (isset($_SESSION['user_id'])) {
  header('location: homepage_student.php');
  exit();
}

// initializing variables
$user_id = "";
$errors = array(); 

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'login');

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Auto-create table if it doesn't exist (consider a separate script for production)
$sql = "CREATE TABLE IF NOT EXISTS users (
  id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11) NOT NULL,
  name VARCHAR(30) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(255) NOT NULL
)";
mysqli_query($db, $sql);

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

      // Hashing user-entered password before comparison
      $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Use a cost of at least 12

      if (password_verify($password, $row['password'])) { // Verify with hashed password
        $_SESSION['user_id'] = $user_id;
        $role = $row['role'];  // Assuming a user_type field exists

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


// LOGOUT USER
//if (isset($_GET['logout'])) {
//  session_destroy();
//  unset($_SESSION['user_id']);
//  header('location: login.php');
//  print_r($_POST);
//  exit();
//}
//?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <div class="header">
     


    <!-- CSS STYLE -->
    <style>
/* General styles */
body {
  font-family: 'Arial', sans-serif;
  margin: 0;
  padding: 0;
  background-color: #e0e0e0;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.wrapper {
  background-color: #ffffff;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
  width: 400px;
  animation: fadeIn 1s ease-in-out;
}

/* Keyframe animation for wrapper fade-in effect */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

/* Login header styles */
.header {
  text-align: center;
  margin-bottom: 25px;
}

.header h1 {
  font-size: 32px;
  color: #333;
  font-weight: 700;
  margin: 0;
  position: relative;
  display: inline-block;
  
}

.header h1::after {
  content: '';
  width: 50%;
  height: 4px;
  background-color: #007bff;
  position: absolute;
  left: 25%;
  bottom: -10px;
  transition: width 0.3s ease-in-out;
}

.header h1:hover::after {
  width: 100%;
  left: 0;
}

/* Login form styles */
h3 {
  text-align: center;
  margin-bottom: 25px;
  font-size: 28px;
  color: #333;
  font-weight: 600;
}

.input-box {
  margin-bottom: 20px;
  position: relative;
}

.input-box input {
  width: 100%;
  padding: 12px 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 16px;
  outline: none;
  transition: border-color 0.3s, box-shadow 0.3s;
}

.input-box input:focus {
  border-color: #007bff;
  box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
}

.input-box i {
  position: absolute;
  top: 50%;
  right: 15px;
  transform: translateY(-50%);
  color: #aaa;
  font-size: 20px;
  transition: color 0.3s;
}

.input-box input:focus + i,
.input-box input:valid + i {
  color: #007bff;
}

/* Remember Me and Forgot Password styles */
.remember-forgot {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.remember-forgot label {
  font-size: 14px;
  color: #555;
}

.remember-forgot a {
  text-decoration: none;
  color: #007bff;
  font-size: 14px;
  transition: color 0.3s;
}

.remember-forgot a:hover {
  color: #0056b3;
  text-decoration: underline;
}

/* Login button styles */
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

/* Register link styles */
.register-link {
  text-align: center;
  margin-top: 20px;
  font-size: 14px;
}

.register-link a {
  text-decoration: none;
  color: #007bff;
  font-weight: 600;
  transition: color 0.3s;
}

.register-link a:hover {
  color: #0056b3;
  text-decoration: underline;
}

/* Error message styles */
.error-message {
  padding: 15px;
  border: 1px solid #ff4d4d;
  border-radius: 5px;
  background-color: #ffe6e6;
  margin-bottom: 20px;
  animation: shake 0.3s;
}

.error-message p {
  color: #ff4d4d;
  font-size: 14px;
}

/* Keyframe animation for error message shake effect */
@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  50% { transform: translateX(5px); }
  75% { transform: translateX(-5px); }
}


</style>




<!-- CSS END STYLE -->

</head>
<body>
<div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3>Login</h3>
        <div class="input-box">
            <input type="text" name="user_id" placeholder="User ID" required>
            <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
            <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="remember-forgot">
            <label><input type="checkbox" name="remember">Remember Me</label>
            <a href="#">Forgot Password</a>
        </div>
        <button type="submit" class="btn" name="login_user">Login</button>
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register</a></p>
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
