<?php
// include the database configuration file
include 'config.php';

// check if the form is submitted
if(isset($_POST['id'])) {
    // sanitize the input using server-side validation
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

    // check if this is the last row in the table
    $result = $conn->query("SELECT COUNT(*) as count FROM view_admin");
    $count = $result->fetch_assoc()['count'];
    if($count == 1) {
        // return an error message
        echo "<script> prompt('Can't delete the only admin in this table(try again after adding an another name:'); </script>";
    } else {
        // prepare the SQL query using a parameterized query to prevent SQL injection
        $stmt = $conn->prepare("DELETE FROM view_admin WHERE id = ?");
        $stmt->bind_param("i", $id);

        // execute the query and check if it was successful
        if($stmt->execute()) {
            // return a success message
            echo "<script> prompt('Deleted successfully'); </script>";
        } else {
            // return an error message
            echo "<script> console.log(Error: $stmt->error) </script>";
        }

        // close the statement and database connection
        $stmt->close();
        $conn->close();
    }
}
?>
