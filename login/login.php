<?php
// Start the session
session_start();

// initializing variables
$username = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'userdb');

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']); //read username input by user
  $password = mysqli_real_escape_string($db, $_POST['password']); //read password input by user

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) { //if user doesn't have errors
    $query = "SELECT * FROM users WHERE username='$username'"; //check database if username exists
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) == 1) {
      $user = mysqli_fetch_assoc($result);
      if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php'); //if it corresponds, user is transferred to index.php
        exit(); // Make sure to exit after the redirect
      } else {
        array_push($errors, "Wrong password");
      }
    } else {
      array_push($errors, "User not found");
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="styles.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<!-- Wrapper for the entire login form -->
  <div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <h3>Engineering Inventory Management System</h3>
      
      <!-- Username input box -->
      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required>
        <i class='bx bxs-user'></i>
      </div>

      <!-- Password input box -->
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
        <i class='bx bxs-lock-alt'></i>
      </div>

      <div class="remember-forgot">
        <label><input type="checkbox" name="remember">Remember Me</label>
        <a href="#">Forgot Password</a>
      </div>

      <!-- Wrapper for the entire login form -->
      <button type="submit" class="btn" name="login_user">Login</button>
      <div class="register-link">
        <p>Don't have an account? <a href="#">Register</a></p>
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
