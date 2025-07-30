<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "residents_ticket";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    // Sanitize the input
    $announcementId = $conn->real_escape_string($_POST["id"]);

    // Update the status of the announcement to "Archived" in the database
    $query = "UPDATE announcements SET status='Archived' WHERE id='$announcementId'";

    if ($conn->query($query) === TRUE) {
        // If the query is successful, return a success message
        echo json_encode(array("success" => true, "message" => "Announcement archived successfully"));
    } else {
        // If the query fails, return an error message
        echo json_encode(array("success" => false, "message" => "Error archiving announcement: " . $conn->error));
    }
} else {
    // If the request method is not POST or 'id' parameter is not set, return an error message
    echo json_encode(array("success" => false, "message" => "Invalid request"));
}

// Close connection
$conn->close();
?>
