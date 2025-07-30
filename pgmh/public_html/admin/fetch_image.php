<?php
$servername = "localhost";
$username = "u614894444_pdmh";
$password = "P0531d0n321";
$dbname = "u614894444_pgmhdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, image_data FROM img";
$result = $conn->query($sql);

$imageDataArray = array();
if ($result->num_rows > 0) {
    // Fetch data and store in an array
    while ($row = $result->fetch_assoc()) {
        $imageDataArray[] = array(
            'id' => $row['id'],
            'image_data' => base64_encode($row['image_data'])
        );
    }
} else {
    echo "0 results";
}
$conn->close();

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($imageDataArray);
?>
