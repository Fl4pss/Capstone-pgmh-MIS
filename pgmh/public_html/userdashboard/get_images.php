<?php
// Database connection
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

// Query to fetch image data from the database
$sql = "SELECT image_data FROM img";
$result = $conn->query($sql);

$imageURLs = array();

// Fetch image data from the result set
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Push each image data to the array
        $imageURLs[] = 'data:image/jpeg;base64,' . base64_encode($row['image_data']);
    }
}

// Close connection
$conn->close();

// Return the image URLs as JSON
echo json_encode($imageURLs);
?>
