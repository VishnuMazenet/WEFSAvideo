<?php
include("config.php");

// Delete the views from the database
$sql = "TRUNCATE TABLE views";

if ($conn->query($sql) === TRUE) {
    // Views deleted successfully
    echo "<script>console.log('Views deleted successfully); </script>";
} else {
    echo "Error deleting views: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
