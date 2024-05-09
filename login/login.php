<?php
// initializing variables
$username = "";
$errors = array(); 

// connect to the database (where database is, username, password, name of dB)


// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) { //if user doesn't have errors
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'"; //check database if password corresponds with username
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php'); //if it corresponds, user is transferred to index.php
  	} else {
  		array_push($errors, "Wrong username/password combination");
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
  <div class="wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <h3>Engineering Inventory Management System</h3>
      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required>
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
