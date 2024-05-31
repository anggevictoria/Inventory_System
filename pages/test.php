<?php

// Include connection details (assuming the file exists)
include "connect.php";

// Test 1: Table creation (if not exists)
echo "** Test 1: Creating table (if not exists) **\n";
$sql = "CREATE TABLE IF NOT EXISTS tool_maintenance (
  tool_id INT(11) NOT NULL,
  FOREIGN KEY (tool_id) REFERENCES tools(id),
  maintenance_date DATE NOT NULL,
  note TEXT NOT NULL
)";

if (!mysqli_query($db, $sql)) {
  echo "Error creating table: " . mysqli_error($db) . "\n";
} else {
  echo "Table created successfully (or already exists).\n";
}

// Test 2: Sending a test email (modify data as needed)
echo "\n** Test 2: Sending test email notification **\n";

// Replace with your test data and email credentials
$sender_email = "dianeendaya4@gmail.com";
$sender_password = "nvzn wisg wwrs zhme";
$recipient_email = "2020661@ub.edu.ph";
$tool_id = 1; // Replace with a valid tool ID (if applicable)
$tool_name = "Test Tool"; // Replace with a test tool name
$maintenance_date = "2024-07-15"; // Replace with a future date

// ---- Email content preparation
$subject = "Test - Tool Maintenance Reminder: " . $tool_name;
$maintenance_description = "This is a test email for maintenance notification.";

$body = "This is a friendly reminder that the maintenance for " . $tool_name . " is due on " . $maintenance_date . ".

Please refer to the following description for the maintenance procedure:

" . $maintenance_description . "

**Please note:** This is a test email. You can disregard it.

Thank you.";

// ---- Send email notification (uncomment to send the test email)
/*
$mail = new PHPMailer(true);

try {
  // Server settings (replace with your email server details if needed)
  $mail->SMTPDebug = 0; // Set to 0 or 2 for detailed debugging
  $mail->isSMTP();
  $mail->Host = 'smtp.example.com'; // Replace with your SMTP server address
  $mail->SMTPAuth = true;
  $mail->Username = $sender_email;
  $mail->Password = $sender_password;
  $mail->SMTPSecure = 'tls'; // Adjust encryption if needed (e.g., 'ssl')
  $mail->Port = 587; // Replace with your SMTP port

  // Sender and recipient information
  $mail->setFrom($sender_email, 'Tool Maintenance System (Test)');
  $mail->addAddress($recipient_email);
  $mail->addReplyTo($sender_email, 'Tool Maintenance System (Test)');

  // Content
  $mail->isHTML(true);
  $mail->Subject = $subject;
  $mail->Body = $body;

  $mail->send();
  echo 'Test email sent successfully.';
} catch (Exception $e) {
  echo "Error sending test email: " . $e->getMessage();
}
*/

// Uncomment the section with `$mail = new PHPMailer(true);` to send a test email notification. 
// Remember to adjust the data and email credentials for the test.

mysqli_close($db); // Close the connection

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tool Maintenance Tester</title>
</head>
<body>