<?php

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'viewcheck');

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>