<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Turn off display of errors but log them instead
ini_set('display_errors', 0); 
ini_set('log_errors', 1);  
ini_set('error_log', '/path/to/your/error.log'); // Log errors to a file

// Buffer output to prevent accidental output before the JSON
ob_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "residents_ticket";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection and return a JSON error if it fails
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit();
}

// Ensure the POST request is handled properly
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_number = $conn->real_escape_string($_POST['admin_number']);
    $password = $_POST['password'];

    // SQL to find admin by admin_number
    $sql = "SELECT id, password FROM admin_credentials WHERE admin_number='$admin_number'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $db_password = $row['password'];

        // Simple password comparison (if passwords are stored in plain text)
        if ($password === $db_password) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_number'] = $admin_number;
            
            // Return success response
            echo json_encode(["success" => true, "message" => "Login successful"]);
        } else {
            // Incorrect password
            echo json_encode(["success" => false, "message" => "Incorrect username or password"]);
        }
    } else {
        // Admin not found
        echo json_encode(["success" => false, "message" => "Incorrect username or password"]);
    }
}

// End buffering and send the JSON response
ob_end_flush();
$conn->close();
?>
