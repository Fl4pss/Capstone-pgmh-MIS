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

$sql = "SELECT id, full_name, email, phone, subject, message, created_at FROM residents_mail";
$result = $conn->query($sql);

$mail_data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $mail_data[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();

echo json_encode($mail_data);
?>
