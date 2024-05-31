<?php
include "admin_connect1.php";

// Create table (if not exists)
$sql = "CREATE TABLE IF NOT EXISTS list(
  student_no INT(11) NOT NULL,
  FOREIGN KEY (student_no) REFERENCES users(user_id),
  email_id VARCHAR(255) NOT NULL,
  FOREIGN KEY (email_id) REFERENCES users(email), 
  program VARCHAR(255) NOT NULL,
  tool_no INT(11) NOT NULL
)";

if (!mysqli_query($db, $sql)) {
  die("Error creating table: " . mysqli_error($db));
} else {
  echo "Table list created successfully";
}

// Prepare data for JavaScript (optional)
$sql = "SELECT * FROM list";
$result = mysqli_query($db, $sql);

if (!$result) {
  echo "Error retrieving data: " . mysqli_error($db);
} else {
  $hasData = (mysqli_num_rows($result) > 0);

  while ($row = mysqli_fetch_assoc($result)) {
    $student_no = $row['student_no'];
    $email = $row['email_id'];
    $program = $row['program'];
    $tool_no = $row['tool_no'];
  }
}

mysqli_close($db);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List of Borrowers</title>
  <style>
  body {
  font-family: Arial, sans-serif;
  margin: 20px;
}

h1, h2 {
  margin-bottom: 10px;
}

/* Table Styles */

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}

/* Form Styles */

form {
  margin-top: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
input[type="number"],
input[type="date"],
textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin-top: 10px;
  cursor: pointer;
  border-radius: 4px;
}

/* Error Styles (Optional) */

.error {
  color: red;
  font-weight: bold;
  margin-top: 10px;
}
</style>
</head>

<body>
  <h1>List of Borrowers</h1>

  <?php
  // Include connection details
  include "admin_connect1.php";


 // Retrieve existing records (optional)
  $sql = "SELECT * FROM lists";
  $result = mysqli_query($db, $sql);

  displayRecords($result);

  // Function to display records (optional)
  function displayRecords($result) {
    if ($result) {
      echo "<table>";
      echo "<tr><th>Student Number</th><th>Program</th><th>Tool ID</th></tr>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['student_no'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['program'] . "</td>";
        echo "<td>" . $row['tool_no'] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "<script>showError('Error retrieving data');</script>";
    }
  }

  // Process form submission (if submitted)
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_no = $_POST['student_no'];
    $email_id = $_POST['email_id'];
    $program = $_POST['program'];
    $tool_no = $_POST['tool_no'];

    // Validate input (optional, add checks for data types, etc.)
    if (empty($student_no) || empty($email_id) || empty($program) || empty($tool_no)) {
      echo "Please fill in all required fields.";
    } else {
      // Insert data into database
      $sql = "INSERT INTO lists (student_no, email_id, program, tool_no) VALUES (?, ?, ?, ?)";
      $stmt = mysqli_prepare($db, $sql);
      mysqli_stmt_bind_param($stmt, "iss", $student_no, $email_id, $program, $tool_no);
      if (mysqli_stmt_execute($stmt)) {
        echo "Maintenance record added successfully!";
      } else {
        echo "Error adding record: " . mysqli_error($db);
      }
      mysqli_stmt_close($stmt);
    }
  }

 
  ?>
<!--
  <h2>Add New Maintenance Record</h2>
  <form method="post">
    <label for="tool_id">Tool ID:</label>
    <input type="number" name="tool_id" id="tool_id" required><br>
    <label for="maintenance_date">Maintenance Date:</label>
    <input type="date" name="maintenance_date" id="maintenance_date" required><br>
    <label for="note">Note:</label>
    <textarea name="note" id="note" rows="5" required></textarea><br>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br>
    <button type="submit">Add Record</button>
  </form>
-->
  <?php
  // Display existing records (call the function)
  displayRecords($result);
  mysqli_close($db); // Close connection
  ?>

</body>
</html>

