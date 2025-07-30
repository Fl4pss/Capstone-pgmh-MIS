<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "residents_ticket";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the message ID from the AJAX request
if (isset($_GET['message_id'])) {
    $messageId = intval($_GET['message_id']);
    
    // Query to fetch the message details based on the message ID
    $sql = "SELECT sender, subject, body, sent_at FROM messages WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $messageId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = $result->fetch_assoc();
        echo '<div class="message-details">';
        echo '<h5 class="fw-bold">From: ' . htmlspecialchars($message['sender']) . '</h5>';
        echo '<p class="small mb-1"><strong>Sent At: </strong>' . date("F jS, Y h:i A", strtotime($message['sent_at'])) . '</p>';
        echo '<h6 class="fw-bold">Subject: ' . htmlspecialchars($message['subject']) . '</h6>';
        echo '<div class="message-body mt-3">' . nl2br(htmlspecialchars($message['body'])) . '</div>';
        echo '</div>';
    } else {
        // If no message is found, display an error message
        echo '<div class="alert alert-danger">Message not found.</div>';
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // If no message ID is provided, display an error message
    echo '<div class="alert alert-danger">No message ID provided.</div>';
}

// Close the database connection
$conn->close();
?>
