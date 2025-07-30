<?php
$host = 'locahost';  
$dbname = 'u614894444_pgmhdb'; 
$username = 'u614894444_pdmh'; 
$password = 'P0531d0n321';  

// Create the connection
$db = new mysqli($host, $username, $password, $dbname);

// Check if connection is successful
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
