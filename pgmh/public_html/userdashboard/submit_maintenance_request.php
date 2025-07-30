<?php
session_start();
include 'db_connection.php'; // Adjust to your database connection file

// Function to send email to the resident
function sendEmailToResident($toEmail, $toName) {
    $fromEmail = "pgmhonline@pgmh.online"; // Replace with your Hostinger email
    $fromName = "PGMH Admin";

    $subject = "Maintenance Request Submitted - Pending Admin Confirmation";
    $message = "
        <html>
        <head>
            <title>Maintenance Request Submitted</title>
        </head>
        <body>
            <p>Dear $toName,</p>
            <p>Your maintenance request has been successfully submitted. It is now pending and will be reviewed by the admin for confirmation.</p>
            <p>Thank you for your patience!</p>
            <p>Best regards,<br>PGMH Team</p>
        </body>
        </html>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $fromName <$fromEmail>" . "\r\n";

    if (mail($toEmail, $subject, $message, $headers)) {
        return true; // Email sent successfully
    } else {
        return false; // Email failed
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the session and POST request
    $name = $_SESSION['full_name']; // Logged-in resident's name from session
    $email = $_SESSION['email']; // Get email from session
    $unit_number = $_POST['unit_number']; // Get unit_number from the POST request
    $urgency = $_POST['urgency'];
    $description = $_POST['description'];
    $issue_type = $_POST['type'];
    $other_issue = isset($_POST['otherIssue']) ? $_POST['otherIssue'] : null;
    $created_at = date('Y-m-d H:i:s'); // Current date and time

    // Handle image upload as binary data (optional)
    $image_data = null;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
        $image_data = file_get_contents($_FILES['attachment']['tmp_name']); // Read file content as binary
    }

    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO maintenance (name, email, location, urgency, description, type, other_issue, created_at, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $name, $email, $unit_number, $urgency, $description, $issue_type, $other_issue, $created_at, $image_data);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        // Send email notification to the resident
        if (sendEmailToResident($email, $name)) {
            echo json_encode(['status' => 'success', 'message' => 'Request submitted successfully and email notification sent!']);
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Request submitted successfully, but failed to send email notification.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'There was an error submitting your request.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
