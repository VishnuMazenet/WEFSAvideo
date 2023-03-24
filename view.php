<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

include "config.php";

$stmt = $conn->prepare("SELECT views FROM views where id = 1");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $views = $row["views"];
    }
} else {
    $views = 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viewers</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="jumbotron">
        <center>
            <h1><b>Admin Panel</b></h1>
        </center>
    </div>
    <div class="container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        <center>
                            <h4>Admin Name</h4>
                        </center>
                    </th>
                    <th colspan="2">
                        <center><button id="addBtn" class="btn btn-success">+ Add</button></center>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "config.php";

                // get the admin names from the database
                $sql = "SELECT * FROM view_admin";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr><td><input type="text" id="name' . $row["id"] . '" class="form-control" value="' . $row["admin_name"] . '"></td><td><button id="updateBtn' . $row["id"] . '" class="btn btn-warning updateBtn" data-id="' . $row["id"] . '">Update</button></td><td><button id="deleteBtn' . $row["id"] . '" class="btn btn-danger deleteBtn" data-id="' . $row["id"] . '">Delete</button></td></tr>';
                    }
                } else {
                    echo '<tr><td colspan="3">No admin names found</td></tr>';
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // handle the update button click
            $(document).on("click", ".updateBtn", function() {
                // get the ID of the admin to update
                let id = $(this).data("id");

                // get the new name of the admin
                let newName = $("#name" + id).val();

                // send an AJAX request to update the admin name in the database
                $.ajax({
                    url: "admin_update.php",
                    type: "POST",
                    data: {
                        id: id,
                        name: newName
                    },
                    success: function(data) {
                        // show a success message
                        location.reload();

                    }
                });
            });

            // handle the delete button click
            $(document).on("click", ".deleteBtn", function() {
                // get the ID of the admin to delete
                let id = $(this).data("id");

                // send an AJAX request to delete the admin from the database
                $.ajax({
                    url: "admin_delete.php",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        if (data === 'forbit') {
                            alert("Can't delete the only admin in this table(try again after adding an another name");
                            location.reload();
                        } else {
                            // remove the deleted admin row from the table
                            $("#name" + id).closest("tr").remove();
                            // show a success message
                            location.reload();

                        }

                    }
                });
            });

            // handle the add button click
            $(document).on("click", "#addBtn", function() {
                // create a new empty row in the table
                let rowHtml = '<tr><td><input type="text" id="newName" class="form-control"></td><td><button id="addNewBtn" class="btn btn-primary">Add</button></td><td><button id="cancelBtn" class="btn btn-secondary">Cancel</button></td></tr>';
                $("table tbody").append(rowHtml);
            });

            // handle the add new admin button click
            $(document).on("click", "#addNewBtn", function() {
                // get the name of the new admin to add
                let newName = $("#newName").val();

                // send an AJAX request to add the new admin to the database
                $.ajax({
                    url: "admin_add.php",
                    type: "POST",
                    data: {
                        name: newName
                    },
                    success: function(data) {
                        // show an error message
                        location.reload();

                    }
                });
            });

            // handle the cancel button click
            $(document).on("click", "#cancelBtn", function() {
                // remove the empty row from the table
                $(this).closest("tr").remove();
            });
        });
    </script>
    <div class="container">
        <h1>Viewers</h1>
        <div class="card text-white bg-secondary mb-3 text-lg-center" style="max-width: 20rem;">
            <div class="card-header">Views</div>
            <div class="card-body">
                <h4 class="card-title">Number of Views</h4>
                <p class="card-text"><?php echo $views; ?></p>
            </div>
        </div>
        <form method="post">
            <button type="submit" id="dview" class="btn btn-warning">Delete Views</button>
            <button type="submit" id="dviewer" class="btn btn-warning">Delete Viewers</button>
        </form>
    </div>

    <script>
        // Search functionality
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#viewerTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            // Delete views button
            $("#dview").click(function() {
                // Show confirmation dialog box
                if (confirm("Are you sure you want to delete the views?")) {
                    // User clicked OK, proceed with AJAX call
                    $.ajax({
                        url: "delete_views.php",
                        type: "POST",
                        success: function(data) {
                            // Reload the page to update the views
                            location.reload();
                        },
                        error: function() {
                            // Show error message
                            alert("Error deleting views");
                        }
                    });
                }
            });

            // Delete viewers button
            $("#dviewer").click(function() {
                // Show confirmation dialog box
                if (confirm("Are you sure you want to delete the viewers?")) {
                    // User clicked OK, proceed with AJAX call
                    $.ajax({
                        url: "delete_viewers.php",
                        type: "POST",
                        success: function(data) {
                            // Reload the page to update the viewers table
                            location.reload();
                        },
                        error: function() {
                            // Show error message
                            alert("Error deleting viewers");
                        }
                    });
                }
            });

        });
    </script>
</body>

</html>

<?php

include("config.php");


// Retrieve the viewers' names from the database
$stmt = $conn->prepare("SELECT * FROM viewers");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Output data of each row
    echo "<div class='container'><br><br>";
    echo '<div class="form-group">';
    echo '<input type="text" class="form-control" id="search" placeholder="Search the Name of the Viewers">';
    echo '</div><br><br>';
    echo '<table class="table table-bordered table-active">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Name</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody id="viewerTable">';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["name"]) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
} else {
    echo '<br><br><center><h3>No viewers found.</h3></center>';
}
echo "<div class='jumbotron'><form action='index.php' method='post'><center><button class='btn btn-outline-primary' type='submit'>Go to the Video Page</button></center></form></div>";
// Close the database connection
$conn->close();
?>