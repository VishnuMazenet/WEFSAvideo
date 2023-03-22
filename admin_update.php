<?php
// include the database configuration file
include 'config.php';

// check if the form is submitted
if(isset($_POST['id']) && isset($_POST['name'])) {
    // sanitize the input using server-side validation
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

    // prepare the SQL query using a parameterized query to prevent SQL injection
    $stmt = $conn->prepare("UPDATE view_admin SET admin_name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);

    // execute the query and check if it was successful
    if($stmt->execute()) {
        // return a success message
        echo "<script> prompt('Updated successfully'); </script>";
    } else {
        // return an error message
        echo "<script> console.log(Error: $stmt->error) </script>";
    }
    
    // close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
