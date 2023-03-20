<?php

include("config.php");

$admin = $_POST['admin'];

$stmt = $conn->prepare("UPDATE `view_admin` SET `admin_name`=? WHERE `id`=1");
$stmt->bind_param("s", $admin);
if ($stmt->execute() === FALSE) {
  echo "Error updating views: " . $stmt->error;
} else {
  echo "<script> console.log('Admin name have been update'); </script>";
}
$stmt->close();

// Close the database connection
$conn->close();
?>