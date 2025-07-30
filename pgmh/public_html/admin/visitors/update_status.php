<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['full_name'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please log in first.']);
    exit;
}

// Database configuration
$host = 'localhost';  
$dbname = 'u614894444_pgmhdb'; 
$username = 'u614894444_pdmh'; 
$password = 'P0531d0n321';  

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// Validate inputs
$visitor_id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : null;
$status = isset($_POST['status']) ? trim($_POST['status']) : '';
$valid_statuses = ['Pending', 'Approved', 'Denied'];

if (!$visitor_id || !$status || !in_array($status, $valid_statuses)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data.']);
    exit;
}

// Function to send status email to the visitor
function sendStatusEmail($toEmail, $visitorName, $status) {
    $fromEmail = "pgmhonline@pgmh.online"; // Replace with your Hostinger email
    $fromName = "PGMH Admin";
    
    $subject = "Visitor Request Update";
    $message = "
        <html>
        <head>
            <title>Visitor Request Update</title>
        </head>
        <body>
            <p>Dear $visitorName,</p>
            <p>Your visitor request has been reviewed by the admin.</p>
            <p>Status: <strong>$status</strong></p>";
    
    if ($status === "Approved") {
        $message .= "<p>Your request has been approved. You may proceed as planned.</p>";
    } elseif ($status === "Denied") {
        $message .= "<p>We regret to inform you that your request has been denied. Please contact us for further details.</p>";
    }

    $message .= "
            <p>Best regards,<br>PGMH Admin Team</p>
        </body>
        </html>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $fromName <$fromEmail>" . "\r\n";

    return mail($toEmail, $subject, $message, $headers);
}

// Fetch visitor details for email
$result = $conn->query("SELECT visitor_name, visitor_email FROM visitor WHERE id = $visitor_id");
if ($result->num_rows == 0) {
    echo json_encode(['status' => 'error', 'message' => 'Visitor not found.']);
    exit;
}

$row = $result->fetch_assoc();
$visitorName = $row['visitor_name'];
$visitorEmail = $row['visitor_email'];

// Update the visitor request status
$stmt = $conn->prepare("UPDATE visitor SET status = ? WHERE id = ?");
if (!$stmt) {
    error_log("SQL error: " . $conn->error);
    echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    exit;
}

$stmt->bind_param("si", $status, $visitor_id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    // Send status email
    if (sendStatusEmail($visitorEmail, $visitorName, $status)) {
        echo json_encode(['status' => 'success', 'message' => 'Status updated and email sent.']);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'Status updated, but email failed to send.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No rows updated.']);
}

$stmt->close();
$conn->close();
?>
