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

// Get activity/facility from the AJAX request
$activity = $_GET['activity'];

// Fetch available time ranges for the selected activity
$stmt = $conn->prepare("SELECT starttime, endtime FROM facility_time_ranges WHERE facility = ?");
$stmt->bind_param("s", $activity);
$stmt->execute();
$result = $stmt->get_result();

$timeRanges = [];

while ($row = $result->fetch_assoc()) {
    $start = date('H:i', strtotime($row['starttime']));
    $end = date('H:i', strtotime($row['endtime']));
    $timeRanges[] = "$start - $end";
}

$stmt->close();
$conn->close();

echo json_encode(["success" => true, "timeRanges" => $timeRanges]);
?>
