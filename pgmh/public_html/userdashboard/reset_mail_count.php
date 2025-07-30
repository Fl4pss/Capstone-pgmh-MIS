<?php
// Connect to your database (replace these values with your actual database credentials)
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

// Update the mail count to 0
$sqlResetMailCount = "UPDATE mail_count SET count = 0";
if ($conn->query($sqlResetMailCount) === TRUE) {
    echo "Mail count reset successfully";
} else {
    echo "Error resetting mail count: " . $conn->error;
}

$conn->close();
?>
