<?php
include "config.php";

$name = $_POST['name'];
$stmt = $conn->prepare("INSERT INTO viewers (name) VALUES (?)");
$stmt->bind_param("s", $name);
$stmt->execute();

$views = $_POST['views'];

++$views;

// Prepare the query to update the number of views in the database
$stmt = $conn->prepare("UPDATE views SET views=? WHERE id=1");
$stmt->bind_param("i", $views);
if ($stmt->execute() === FALSE) {
  echo "Error updating views: " . $stmt->error;
} else {
  echo "<script> console.log('Views have been update'); </script>";
}
$stmt->close();

// Close the database connection
$conn->close();
?>
