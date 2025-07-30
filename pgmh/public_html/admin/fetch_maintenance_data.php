<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "residents_ticket";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT urgency, COUNT(*) as count FROM maintenance WHERE status='Pending' GROUP BY urgency";
$result = $conn->query($sql);

$ticket_counts = array("low" => 0, "moderate" => 0, "high" => 0);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ticket_counts[strtolower($row['urgency'])] = $row['count'];
    }
}

$conn->close();

echo json_encode($ticket_counts);
?>
