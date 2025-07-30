<?php
$servername = "localhost";
$username = "u614894444_pdmh";
$password = "P0531d0n321";
$dbname = "u614894444_pgmhdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the ID of the mail to be deleted
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;

// Delete mail from the database
$sql = "DELETE FROM residents_mail WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false));
}

$conn->close();
?>
