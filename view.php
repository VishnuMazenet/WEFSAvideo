<?php

include("config.php");

$stmt = $conn->prepare("SELECT admin_name FROM view_admin");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $admin = $row['admin_name'];
    }
}
echo "<div class='container'>";
echo "<div class='card text-white bg-success mb-3' style='max-width: 20rem;'>";
echo " <div class='card card-header'><h5><b>Edit Admin Name</b></h5></div>";
echo "<div class='card-body'>";
// echo "<h4 class='card card-title'>Edit Admin Name</h4>";
echo "<input type = 'text' class='form-control' placeholder='Admin Name' id='admin' value = '$admin'></input><br>";
echo "<button class = 'card btn btn-success bg bg-success' id = 'update_admin' type = 'submit'>Update</button>";
echo "</div>";
echo "</div>";
echo "</div>";

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

// Retrieve the viewers' names from the database
$sql = "SELECT * FROM viewers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    echo "<div class='container'><br><br>";
    echo '<div class="form-group">';
    echo '<input type="text" class="form-control" id="search" placeholder="Search">';
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

// Close the database connection
$conn->close();
?>
</div>


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
                var value = $(this).val().toLowerCase();
                $("#viewerTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            //Update Admin
            $("#update_admin").click(function() {
                var admin = document.getElementById("admin").value;
                $.ajax({
                    url: "admin_update.php",
                    type: "POST",
                    data: {
                        admin: admin
                    },
                    success: function(data) {
                        //alert(data);
                        location.reload();
                    },
                    error: function() {
                        alert("Error updating admin name");
                    }
                })
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
                            // Show success message
                            // alert(data);
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
                            // Show success message
                            // alert(data);
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