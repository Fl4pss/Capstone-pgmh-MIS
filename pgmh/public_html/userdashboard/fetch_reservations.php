<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "residents_ticket";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit();
}

$date = $_GET['date'];
$activity = $_GET['activity'];

$stmt = $conn->prepare("SELECT starttime, endtime FROM reservations WHERE date = ? AND activity = ?");
$stmt->bind_param("ss", $date, $activity);
$stmt->execute();
$result = $stmt->get_result();

$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode(["success" => true, "reservations" => $reservations]);
?>
