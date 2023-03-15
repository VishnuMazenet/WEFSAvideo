<?php

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'viewcheck');

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>