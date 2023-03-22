<?php
session_start();
include "config.php";

$admin = $_POST['name'];

$stmt = $conn->prepare("SELECT admin_name FROM view_admin WHERE admin_name = ?");
$stmt->bind_param("s", $admin);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['admin'] = $row['admin_name'];
    echo "match";
} else {
    echo "no match";
}

$stmt->close();
$conn->close();
exit();
