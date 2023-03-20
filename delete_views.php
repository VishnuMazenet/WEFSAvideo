<?php
include("config.php");

// Delete the views from the database
$sql = "UPDATE views SET views=0 WHERE id=1";

if ($conn->query($sql) === TRUE) {
    // Views deleted successfully
    echo "<script>console.log('Views reseted successfully');</script>";
} else {
    echo "Error deleting views: " . $conn->error;
}

// Close the database connection
$conn->close();
?>