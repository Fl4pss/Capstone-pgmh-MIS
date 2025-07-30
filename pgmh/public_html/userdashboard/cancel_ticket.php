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

// Check if the ID parameter is provided in the request
if(isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Check if the ID parameter is for maintenance or reservations table
    $table = isset($_GET['table']) && $_GET['table'] === 'reservations' ? 'reservations' : 'maintenance';

    // Prepare and execute the SQL query to delete the ticket or reservation
    $sql = "DELETE FROM $table WHERE id = '$id'";
    echo "Debug: SQL Query: $sql"; // Debugging
    if ($conn->query($sql) === TRUE) {
        // Return success message if the ticket or reservation is successfully deleted
        http_response_code(200);
        echo json_encode(array("message" => ucfirst($table) . " canceled successfully"));
    } else {
        // Return error message if there was an error deleting the ticket or reservation
        http_response_code(500);
        echo json_encode(array("message" => "Error canceling " . $table . ": " . $conn->error));
    }
} else {
    // Return error message if the ID parameter is missing
    http_response_code(400);
    echo json_encode(array("message" => "ID parameter is missing"));
}

// Close connection
$conn->close();
?>