<?php

include "config.php";
$stmt = $conn->prepare("SELECT views FROM views");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $views = $row["views"];
    }
}
include("config.php");

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
        });
    </script>
</body>

</html>