<?php
// Include connection details
include "admin_connect1.php";

$sql = "CREATE TABLE IF NOT EXISTS borrowed_items (
  student_id INT(11),
  FOREIGN KEY (student_id) REFERENCES users(id),
  id_tool INT NOT NULL,
  FOREIGN KEY (id_tool) REFERENCES tools(id),
  quan INT NOT NULL,
  FOREIGN KEY (quan) REFERENCES tools(quantity),
  borrowed_date DATE NOT NULL,
  returned_date DATE NOT NULL,
  returned_time TIME NOT NULL
)";

if (!mysqli_query($db, $sql)) {
  die("Error creating table: " . mysqli_error($db));
}

// Retrieve existing records (optional)
$sql = "SELECT * FROM borrowed_items";
$result = mysqli_query($db, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Borrowed Items</title>
  
  <style>
    /* Basic form styling */
    form {
      width: fit-content;
      margin: 20px auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    input[type="time"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
      margin-bottom: 15px;
    }

    button[type="submit"] {
      background-color: #4CAF50; /* Green */
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
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

</style>

</head>
<body>
  <h1>Borrowed Items</h1>

  <?php
  // Display the table of borrowed items
  if ($result && mysqli_num_rows($result) > 0) {
    echo '<div class="table-container">';
    echo "<table>";
    echo "<tr><th>Tool ID:</th><th>Quantity:</th><th>Status</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
      $itemId = $row['id_tool']; // Assuming 'id' is the unique identifier for the record
      $isReturned = $row['returned_date'] != null; // Check if a returned date is set (assuming 'returned_date' indicates a returned item)

      echo "<tr>";
      echo "<td>" . $row['id_tool'] . "</td>";
      echo "<td>" . $row['quan'] . "</td>";
      echo "<td>";
      if ($isReturned) {
        echo "Returned";
      } else {
        echo '<button id="returnButton_' . $itemId . '" data-item-id="' . $itemId . '">Return</button>';
      }
      echo "</td>";
      echo "</tr>";
    }

    echo "</table>";
    echo '</div>';
  } else {
    echo "No records found.";
  }
  ?>

  <script>
    // JavaScript to handle returning items (simulate for demo)
    const returnButtons = document.querySelectorAll("[id^='returnButton_']"); // Select all buttons with IDs starting with "returnButton_"
    returnButtons.forEach(button => {
      button.addEventListener("click", function() {
        const itemId = this.dataset.itemId;
        // Simulate updating the item status (replace with your logic)
        this.textContent = "Returned";
        this.disabled = true;
        // Consider sending an AJAX request to update the status on the server-side
      });
    });
  </script>

</body>
</html>
