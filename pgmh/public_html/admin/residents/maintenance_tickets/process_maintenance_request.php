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
    // Get data from the form submission
    $name = $_POST['name']; // Name from the form
    $email = $_POST['email']; // Email from the form
    $location = $_POST['location']; // Get location from the POST request (used as unit number)
    $description = $_POST['description'];
    $issue_type = $_POST['type'];
    $created_at = date('Y-m-d H:i:s'); // Current date and time

    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO maintenance (name, email, location, description, type, created_at, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $status = 'Pending'; // Default status
    $stmt->bind_param("sssssss", $name, $email, $location, $description, $issue_type, $created_at, $status);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        // Send email notification to the resident
        $emailStatus = sendEmailToResident($email, $name);
        
        $response = [
            'status' => 'success',
            'message' => $emailStatus
                ? 'Request submitted successfully and email notification sent!'
                : 'Request submitted successfully, but failed to send email notification.',
        ];
    } else {
        $response = ['status' => 'error', 'message' => 'There was an error submitting your request.'];
    }

    $stmt->close();
    $conn->close();

    // Return JSON response
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
