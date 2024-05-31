<?php

include "admin_connect.php";


if (isset($_POST['search'])) {
  $searchTerm = trim($_POST['search']); // Sanitize user input

  if (!empty($searchTerm)) {
    // Connect to your database (replace with your connection details)
    $db = mysqli_connect('localhost', 'root', '', 'inventory');

    // Check connection
    if (!$db) {
      die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare a SQL query with parameter binding to prevent SQL injection
    $sql = "SELECT * FROM tools WHERE tool_name LIKE ? OR def LIKE ?";
    $stmt = mysqli_prepare($db, $sql);

    // Bind search term as parameter (twice for tool name and def)
    mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
      echo "<h3>Search Results for '$searchTerm':</h3>";
      // Display search results here (loop through $result)
      while ($row = mysqli_fetch_assoc($result)) {
        // Example: Display tool name and description
        echo "<p>Tool Name: " . $row['tool_name'] . "</p>";
        echo "<p>Description: " . $row['def'] . "</p>";
        echo "<hr>"; // Optional separator between results
      }
    } else {
      echo "No matching tools found for your search.";
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($db);

  } else {
    echo "Please enter a search term.";
  }
}

?>


<!DOCTYPE html>
<html>
<head>
  <style>
    .search-bar {
      position: absolute;
      top: 10px; /* Adjust top and right values for positioning */
      right: 10px;
      display: flex; /* Arrange search box and button horizontally */
    }
  </style>
</head>
<body>
  <div class="search-bar">
    <form action="" method="post">
      <input type="text" name="search" placeholder="Search CPE/IE tools...">
      <button type="submit">Search</button>
    </form>
  </div>

  <?php
    // ... your existing PHP code ...
  ?>
</body>
</html>
