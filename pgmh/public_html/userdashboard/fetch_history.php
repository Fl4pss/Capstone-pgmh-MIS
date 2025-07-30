<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'residents_ticket';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from maintenance table
$maintenance_sql = "SELECT * FROM maintenance";
$maintenance_result = $conn->query($maintenance_sql);
$maintenance_data = array();

if ($maintenance_result->num_rows > 0) {
    while($row = $maintenance_result->fetch_assoc()) {
        $maintenance_data[] = $row;
    }
}

// Fetch data from reservations table
$reservations_sql = "SELECT * FROM reservations";
$reservations_result = $conn->query($reservations_sql);
$reservations_data = array();

if ($reservations_result->num_rows > 0) {
    while($row = $reservations_result->fetch_assoc()) {
        $reservations_data[] = $row;
    }
}

// Prepare data to be returned as JSON
$response = array(
    'maintenance' => $maintenance_data,
    'reservations' => $reservations_data
);

// Set header to JSON
header('Content-Type: application/json');

// Return data as JSON
echo json_encode($response);

// Close connection
$conn->close();
?>
