<?php

include "config.php";

$name = $_POST['name'];

$stmt = $conn->prepare("SELECT admin_name FROM view_admin WHERE admin_name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo "match";
} else {
    echo "no match";
}
$stmt->close();
$conn->close();
