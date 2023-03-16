<?php
include("config.php");

// Delete all viewers from the database
$sql = "TRUNCATE TABLE viewers";

if ($conn->query($sql) === TRUE) {
    // Viewers deleted successfully
    echo "<script>console.log('Viewers deleted successfully); </script>";
} else {
    echo "Error deleting viewers: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
