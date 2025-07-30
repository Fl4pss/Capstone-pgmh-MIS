<?php
session_start();

// Database connection
$servername = "localhost";
$username = "u614894444_pdmh"; // Replace with your DB username
$password = "P0531d0n321"; // Replace with your DB password
$dbname = "u614894444_pgmhdb"; // Replace with your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}