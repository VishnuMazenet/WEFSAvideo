<?php
include "config.php";

// Prepare the query to retrieve the number of views from the database
$stmt = $conn->prepare("SELECT views FROM views");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // Output data of each row
  while ($row = $result->fetch_assoc()) {
    $views = $row["views"];
  }
} else {
  $views = 0;
  $stmt = $conn->prepare("INSERT INTO views (views) VALUE (?)");
  $stmt->bind_param("i", $views);
  $stmt->execute();
  $result = $stmt->get_result();
}

// Increment the number of views
// ++$views;

// // Prepare the query to update the number of views in the database
// $stmt = $conn->prepare("UPDATE views SET views=? WHERE id=1");
// $stmt->bind_param("i", $views);
// if ($stmt->execute() === FALSE) {
//   echo "Error updating views: " . $stmt->error;
// } else {
//   echo "<script> console.log('Views have been update'); </script>";
// }

// Close the prepared statement and database connection
$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WEFSA</title>
  <link rel="stylesheet" href="bootstrap.min.css">
  <script src="jquery-3.6.4.min.js"></script>
  <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="https://wefsa.com/">WEFSA</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor03">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <form class="form-inline my-2 my-lg-0">
          <label>WELCOME... </label>
          <label id='name'></label>
        </form>
    </div>
  </nav>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <p class="my-3">Views: <?php echo $views; ?></p>
        <video width="100%" controls>
          <source src="video.mp4" type="video/mp4">
        </video>
      </div>
    </div>
  </div>
  <!-- jQuery and Bootstrap Bundle (includes Popper) -->
  <script>
    $(document).ready(function() {
      var name = prompt("Please enter your name:");
      document.getElementById('name').innerHTML = name;
      while (name === "" || name === null) {
        name = prompt("Please enter your name to continue watching the video:");
      }
      if (name !== null && name !== "") {
        $.ajax({
          url: "save.php",
          method: "POST",
          data: {
            name: name,
            views: '<?php echo $views; ?>'
          },
          success: function(response) {
            console.log(response);
            console.log("Name updated");
          },
          error: function() {
            console.log("error");
          }
        });
      }
    });
    document.getElementById('name').innerHTML = name;
  </script>

</body>

</html>