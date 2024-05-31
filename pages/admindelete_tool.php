<?php
include "admin_connect.php"; // Replace with your connection details

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $toolId = isset($_POST['tool_id']) ? intval($_POST['tool_id']) : 0;

  if ($toolId > 0) {
    $sql = "DELETE FROM tools WHERE id = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "i", $toolId);

    if (mysqli_stmt_execute($stmt)) {
      echo "success"; // Send success message on successful deletion
    } else {
      echo "error: " . mysqli_error($db); // Send error message on failure
    }

    mysqli_stmt_close($stmt);
  } else {
    echo "error: Invalid tool ID"; // Handle invalid data
  }
} else {
  echo "error: Not a POST request"; // Handle invalid request method
}

mysqli_close($db); // Close connection