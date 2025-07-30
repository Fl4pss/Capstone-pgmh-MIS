<?php
// Database connection parameters
$host = 'localhost'; // Your MySQL host
$username = 'root'; // Your MySQL username
$password = ''; // Your MySQL password
$database = 'residents_ticket'; // Your MySQL database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die(json_encode(array('success' => false, 'error' => 'Connection failed: ' . $conn->connect_error)));
}

// Check if the ID parameter is set
if (!isset($_GET['id'])) {
    die(json_encode(array('success' => false, 'error' => 'Resident ID not provided')));
}

$id = $_GET['id'];

// Prepare and execute the query to archive the resident
$sql = "INSERT INTO archived_residents (resident_id, full_name, email, contact_number, unit_number, password) 
        SELECT id, full_name, email, contact_number, unit_number, password FROM residents WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();

// Check if the resident was successfully archived
if ($stmt->affected_rows > 0) {
    // Delete the resident from the residents table
    $deleteSql = "DELETE FROM residents WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param('i', $id);
    $deleteStmt->execute();

    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'error' => 'Failed to archive resident'));
}

// Close the statements and the database connection
$stmt->close();
$deleteStmt->close();
$conn->close();
?>
