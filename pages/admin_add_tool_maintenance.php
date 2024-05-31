<?php

// Start session
session_start();

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'inventory');

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Include connection details
include "forms/admin_connect.php";

$sql = "CREATE TABLE IF NOT EXISTS tool_maintenance (
  tool_id INT(11),
  FOREIGN KEY (tool_id) REFERENCES tools(id),
  maintenance_date DATE NOT NULL,
  note TEXT NOT NULL,
  email VARCHAR(255) NOT NULL
)";

if (!mysqli_query($db, $sql)) {
  die("Error creating table: " . mysqli_error($db));
} else {
  echo "Table tool_maintenance created successfully";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tool Maintenance Records</title>
  <style>
  body {
    font-family: Arial, sans-serif;
    margin: 20px;
  }

  h1, h2 {
    margin-bottom: 10px;
  }

  /* Header Styles */
  header {
    background-color: #800000; /* Maroon */
    color: white;
    padding: 10px 0;
    text-align: center;
    margin-bottom: 20px;
  }

  header nav a {
    color: white;
    margin: 0 15px;
    text-decoration: none;
  }

  header nav a:hover {
    text-decoration: underline;
  }

  /* Center the table */
  .table-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }

  /* Table Styles */
  table {
    border-collapse: collapse;
    width: 100%;
    max-width: 800px; /* Adjust the max width as needed */
  }

  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  th {
    background-color: #f2f2f2;
  }

  /* Modal Styles */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
  }

  .modal-content {
    background-color: #fefefe;
    margin: 5% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
    max-width: 500px;
  }

  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
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
    background-color: #800000; /* Maroon */
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

  /* Success Message Styles */
  .success {
    color: green;
    font-weight: bold;
    margin-top: 10px;
  }
  </style>
</head>

<header style="display: flex; align-items: center;">
  <img src="admin/assets/img/IS Logo.png" alt="" style="margin-right: 10px; float: left;">
  <h1 style="margin-left: auto;">Tool Maintenance Records</h1>
</header>

  <?php
  // Initialize a variable to hold success message
  $success_message = "";

  // Process form submission (if submitted)
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tool_id = $_POST['tool_id'];
    $maintenance_date = $_POST['maintenance_date'];
    $note = $_POST['note'];
    $email = $_POST['email'];

  }
    // Validate input (add checks for data types, etc.)
if (empty($tool_id) || empty($maintenance_date) || empty($note) || empty($email)) {
  // echo "Please fill in all required fields.";
} else {
  // Improved validation (consider adding more specific checks)
  if (!strtotime($maintenance_date)) {
    echo "Invalid date format. Please use YYYY-MM-DD.";
    exit(); // Stop script execution on invalid date
  }

  // Insert data into database
  $sql = "INSERT INTO tool_maintenance (tool_id, maintenance_date, note, email) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_prepare($db, $sql);

  // Optional: Adjust data types based on your table schema
  mysqli_stmt_bind_param($stmt, "isss", $tool_id, $maintenance_date, $note, $email);

  if (mysqli_stmt_execute($stmt)) {
    echo "Maintenance record added successfully!";
  } else {
    // Improved error handling
    $error = mysqli_stmt_error($stmt);
    echo "Error adding record: $error";
  }

  mysqli_stmt_close($stmt); // Close the statement
  
}
  

  // Retrieve existing records (optional)
  $sql = "SELECT * FROM tool_maintenance";
  $result = mysqli_query($db, $sql);

  // Function to display records (optional)
  function displayRecords($result) {
    if ($result) {
      echo '<div class="table-container">';
      echo "<table>";
      echo "<tr><th>Tool ID</th><th>Maintenance Date</th><th>Note</th><th>Email</th></tr>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['tool_id'] . "</td>";
        echo "<td>" . $row['maintenance_date'] . "</td>";
        echo "<td>" . $row['note'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
      echo '</div>';
    } else {
      echo "Error retrieving data";
    }
  }
  ?>

  <!-- Display success message if exists -->
  <?php if (!empty($success_message)): ?>
    <div class="success">
      <?php echo $success_message; ?>
    </div>
  <?php endif; ?>

  <button id="myBtn">Add New Maintenance Record</button>

  <!-- The Modal -->
  <div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
      <span class="close">&times;</span>
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
    </div>
  </div>

  <?php
  // Display existing records (call the function)
  displayRecords($result);
  mysqli_close($db); // Close connection
  ?>

  <script>
  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the button that opens the modal
  var btn = document.getElementById("myBtn");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks the button, open the modal
  btn.onclick = function() {
    modal.style.display = "block";
  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
  </script>

</body>
</html>
