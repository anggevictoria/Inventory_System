<?php

include "admin_connect.php";

// Get POST data and sanitize
$tool_id = filter_input(INPUT_POST, "tool_id", FILTER_SANITIZE_NUMBER_INT);
$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);

if ($tool_id && $name && $description) {
    $sql = "UPDATE tool_records SET name = ?, description = ? WHERE tool_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ssi", $name, $description, $tool_id); // Bind parameters to prevent SQL injection

    if ($stmt->execute()) {
        echo "Tool record updated successfully!";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid input.";
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Tool Record</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <h1>Update Tool Record</h1>
  <?php
  // Assuming you have a script to retrieve tool information based on ID (modify as needed)
  include "admin_connect.php";
  
  function get_tool_info($tool_id, $db) {
      $sql = "SELECT * FROM tool_records WHERE tool_id = ?";
      $stmt = $db->prepare($sql);
      $stmt->bind_param("i", $tool_id);
      $stmt->execute();
      $result = $stmt->get_result();
      return $result->fetch_assoc();
  }

  $tool_id = filter_input(INPUT_GET, 'tool_id', FILTER_SANITIZE_NUMBER_INT);
  $tool_info = get_tool_info($tool_id, $db); // Replace with your function to retrieve data

  if ($tool_info) {
  ?>
  <form id="updateForm">
    <input type="hidden" name="tool_id" id="tool-id" value="<?php echo $tool_info['tool_id']; ?>">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?php echo $tool_info['name']; ?>">
    <br>
    <label for="description">Description:</label>
    <textarea name="description" id="description"><?php echo $tool_info['description']; ?></textarea>
    <br>
    <button type="button" id="update-button">Update Tool Record</button>
  </form>
  <?php } else { ?>
    <p>Error: Could not find tool record with ID: <?php echo htmlspecialchars($tool_id); ?></p>
  <?php } ?>

  <script>
    document.getElementById('update-button').addEventListener('click', function() {
      const toolId = document.getElementById('tool-id').value;
      const name = document.getElementById('name').value;
      const description = document.getElementById('description').value;

      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'update_tool_record.php');
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          alert(xhr.responseText);
          // Optionally, update the UI to reflect the changes
        } else {
          alert('Error updating record: ' + xhr.statusText);
        }
      };

      xhr.send('tool_id=' + encodeURIComponent(toolId) + '&name=' + encodeURIComponent(name) + '&description=' + encodeURIComponent(description));
    });
  </script>
</body>
</html>
