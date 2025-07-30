<?php
$servername = "localhost"; // or your server's address
$username = "root"; // database username
$password = ""; // database password
$dbname = "residents_ticket"; // name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
