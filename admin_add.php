<?php
// include the database configuration file
include 'config.php';

// check if the form is submitted
if(isset($_POST['name'])) {
    // sanitize the input using server-side validation
    $name = filter_var($_POST['name'], FILTER_UNSAFE_RAW);

    // prepare the SQL query using a parameterized query to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO view_admin (admin_name) VALUES (?)");
    $stmt->bind_param("s", $name);

    // execute the query and check if it was successful
    if($stmt->execute()) {
        // return a success message
        echo "<script> console.log('Added Successfully') </script>";
    } else {
        // return an error message
        echo "<script> console.log(Error: $stmt->error) </script>";
    }
    
    // close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
