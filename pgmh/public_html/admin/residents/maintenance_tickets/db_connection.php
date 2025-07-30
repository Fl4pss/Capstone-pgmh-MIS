<?php
$servername = "localhost";
$username = "u614894444_pdmh";
$password = "P0531d0n321"; 
$database = "u614894444_pgmhdb"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
