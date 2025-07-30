<?php

$host = 'localhost';  
$dbname = 'u614894444_pgmhdb'; 
$username = 'u614894444_pdmh'; 
$password = 'P0531d0n321';  

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to send confirmation email to the visitor
function sendConfirmationEmail($toEmail, $visitorName) {
    $fromEmail = "pgmhonline@pgmh.online"; // Replace with your Hostinger email
    $fromName = "PGMH Admin";
    
    $subject = "Visitor Request Received";
    $message = "
        <html>
        <head>
            <title>Visitor Request Received</title>
        </head>
        <body>
            <p>Dear $visitorName,</p>
            <p>Thank you for submitting your visitor request. Your request has been received and is pending confirmation from the admin.</p>
            <p>We will notify you once the admin approves your request.</p>
            <p>Best regards,<br>PGMH Admin Team</p>
        </body>
        </html>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $fromName <$fromEmail>" . "\r\n";

    return mail($toEmail, $subject, $message, $headers);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $visitor_name = $conn->real_escape_string($_POST['visitor_name']);
    $visitor_email = $conn->real_escape_string($_POST['visitor_email']);
    $contact_number = $conn->real_escape_string($_POST['contact_number']);
    $resident_name = $conn->real_escape_string($_POST['resident_name']);
    $visit_date = $conn->real_escape_string($_POST['visit_date']);
    $visit_time = $conn->real_escape_string($_POST['visit_time']);
    $purpose_of_visit = $conn->real_escape_string($_POST['purpose_of_visit']);

    $sql = "INSERT INTO visitor (visitor_name, visitor_email, contact_number, resident_name, visit_date, visit_time, purpose_of_visit)
            VALUES ('$visitor_name', '$visitor_email', '$contact_number', '$resident_name', '$visit_date', '$visit_time', '$purpose_of_visit')";

    if ($conn->query($sql) === TRUE) {
        // Send confirmation email
        if (sendConfirmationEmail($visitor_email, $visitor_name)) {
            echo "New visit request submitted successfully. A confirmation email has been sent.";
        } else {
            echo "New visit request submitted successfully, but failed to send confirmation email.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
