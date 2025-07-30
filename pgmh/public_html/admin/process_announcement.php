<?php
// Set the timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Database connection details
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $title = htmlspecialchars($_POST['inputTitle']);
    $content = htmlspecialchars($_POST['inputContent']);
    $start_date = $_POST['inputStartDate'];
    $start_time = $_POST['inputStartTime'];
    $end_date = $_POST['inputEndDate'];
    $end_time = $_POST['inputEndTime'];

    // Combine date and time into datetime strings
    $start_datetime_str = $start_date . ' ' . $start_time;
    $end_datetime_str = $end_date . ' ' . $end_time;

    // Convert to DateTime objects
    $start_datetime = new DateTime($start_datetime_str);
    $end_datetime = new DateTime($end_datetime_str);
    $current_datetime = new DateTime();

    // Determine status
    if ($current_datetime <= $start_datetime) {
        $status = 'Pending';
    } elseif ($current_datetime >= $start_datetime && $current_datetime <= $end_datetime) {
        $status = 'Active';
    } else {
        $status = 'Archived';
    }

    // Prepare and execute SQL query
    $stmt = $conn->prepare("INSERT INTO announcements (title, content, start_date, start_time, end_date, end_time, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $bind = $stmt->bind_param("sssssss", $title, $content, $start_date, $start_time, $end_date, $end_time, $status);
    if ($bind === false) {
        die('Bind failed: ' . htmlspecialchars($stmt->error));
    }

    $execute = $stmt->execute();
    if ($execute === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    } else {
        echo "Announcement posted successfully.";
    }

    $stmt->close();
} else {
    echo "No POST data received.";
}

$conn->close();
?>
