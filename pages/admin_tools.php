<?php
include "admin_connect.php";

// Create tables (if not exist)
$sql = "CREATE TABLE IF NOT EXISTS tools (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tool_name VARCHAR(255) NOT NULL,
  quantity INT(11) NOT NULL,
  def TEXT NOT NULL,
  category_name VARCHAR(255) NOT NULL,
  category_id INT(11) NOT NULL
)";
mysqli_query($db, $sql);

// Retrieve data from tools table
$sql = "SELECT * FROM tools";
$result = mysqli_query($db, $sql);

if (!$result) {
  echo "Error retrieving data: " . mysqli_error($db);
}

mysqli_close($db); // Close the connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tool Records</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    header {
      background-color: #f8f9fa;
      padding: 20px;
      display: flex;
      align-items: center;
    }

    .header-image {
      width: 100px; /* Adjust the size as needed */
      height: auto; /* Maintain aspect ratio */
    }

    h1 {
      margin: 0;
      font-size: 2em;
      flex-grow: 1;
      text-align: center;
    }

    h1, h2 {
      margin-bottom: 10px;
    }

    .card {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      margin: 20px 0;
      padding: 20px;
      width: 90%;
      max-width: 1200px;
      margin: 20px auto; /* Center the card */
    }

    .card h2 {
      margin-top: 0;
    }

    .card p {
      font-size: 1em;
      color: #333;
    }

    /* Table Styles */
    table {
      border-collapse: collapse;
      width: 90%;
      max-width: 1200px;
      margin: 20px auto; /* Center the table */
    }

    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center; /* Center table contents */
    }

    th {
      background-color: #f2f2f2;
    }

    /* Specific style for description column */
    td.description {
      text-align: justify; /* Justify the description text */
    }

    /* Button Styles */
    #add-tool-btn {
      background-color: #6b1500;
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

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 500px;
      border-radius: 8px;
    }

    .modal-header {
      background-color: #6b1500; /* Your desired color */
      color: white;
      padding: 10px;
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
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
      background-color: #6b1500;
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
  <header>
    <img src="admin/assets/img/UBLogo.png" alt="IS Logo" class="header-image">
    <h1>Tool Records</h1>
  </header>

  <div class="card">
    <h2>Add a New Tool</h2>
    <p>To add a new tool, click on the "Add Tool" button below and fill in the required details.</p>
    <button id="add-tool-btn">Add Tool</button>
  </div>

  <div id="addToolModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <div class="modal-header">
        <h2>Add New Tool Record</h2>
      </div>
      <form method="post" id="add-tool-form">
        <label for="tool_name">Tool Name:</label>
        <input type="text" id="tool_name" name="tool_name" required>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>

        <label for="def">Description:</label>
        <textarea id="def" name="def" required></textarea>

        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category_name" required>

        <label for="category_id">Category ID:</label>
        <input type="number" id="category_id" name="category_id" required>

        <button type="submit">Add Tool</button>
      </form>
    </div>
  </div>

  <?php
  // Display tool records
  function displayRecords($result) {
    if ($result) {
      echo "<table>";
      echo "<tr>
              <th>Tool Name</th>
              <th>Quantity</th>
              <th>Description</th>
              <th>Category</th>
              <th>Category ID</th>
              <th>Action</th>
            </tr>";

      while ($row = mysqli_fetch_assoc($result)) {
        $tool_id = $row['id'];

        echo "<tr>";
        echo "<td><span contenteditable='true' data-id='$tool_id'>" . $row['tool_name'] . "</span></td>";
        echo "<td><span contenteditable='true' data-id='$tool_id'>" . $row['quantity'] . "</span></td>";
        echo "<td class='description'><span contenteditable='true' data-id='$tool_id'>" . $row['def'] . "</span></td>";
        echo "<td><span contenteditable='true' data-id='$tool_id'>" . $row['category_name'] . "</span></td>";
        echo "<td><span contenteditable='true' data-id='$tool_id'>" . $row['category_id'] . "</span></td>";
        echo "<td>
                <button class='edit-btn' data-id='$tool_id'>Edit</button>
                <button class='delete-btn' data-id='$tool_id'>Delete</button>
              </td>";
        echo "</tr>";
      }

      echo "</table>";
    } else {
      echo "Error retrieving data";
    }
  }

  // Retrieve data again for displaying after including function
  $db = mysqli_connect($servername, $username, $password, $dbname);
  $sql = "SELECT * FROM tools";
  $result = mysqli_query($db, $sql);
  displayRecords($result);
  mysqli_close($db); // Close the connection
  ?>

  <script>
    // JavaScript for Modal
    var modal = document.getElementById("addToolModal");
    var btn = document.getElementById("add-tool-btn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
      modal.style.display = "block";
    }

    span.onclick = function() {
      modal.style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>

</body>
</html>