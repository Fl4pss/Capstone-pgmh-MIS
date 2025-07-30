<?php
// Database connection details
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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("UPDATE announcements SET status = 'Archived' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Announcement archived successfully.";
    } else {
        echo "Failed to archive announcement.";
    }

    $stmt->close();
} else {
    echo "ID parameter is missing.";
}

$conn->close();
?>
