<?php
// Database connection
$servername = "localhost";
$username = "u614894444_pdmh"; // Your database username
$password = "P0531d0n321"; // Your database password
$dbname = "u614894444_pgmhdb"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to send email to the user
function sendEmailToResident($toEmail, $rawPassword) {
    $fromEmail = "pgmhonline@pgmh.online"; // Replace with your Hostinger email
    $fromName = "PGMH Admin";

    $subject = "Password Reset Request";
    $message = "
        <html>
        <head>
            <title>Password Reset</title>
        </head>
        <body>
            <p>You have requested to reset your password. Below are your login details:</p>
            <p><strong>Email:</strong> $toEmail<br>
            <strong>New Password:</strong> $rawPassword</p>
            <p>Please log in to the system using the following link:<br>
            <a href='https://pgmh.online' target='_blank'>PGMH Online</a></p>
            <p>If you did not request a password reset, please ignore this email.</p>
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

// Check if the email form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['forgotEmail']);

    // Check if email exists in the database
    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists, generate a new random password
        $newPassword = bin2hex(random_bytes(4)); // Generates an 8-character password
        
        // Update the password in the database (hashed for security)
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateSql = "UPDATE users SET password = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $hashedPassword, $email);

        if ($updateStmt->execute()) {
            // Send the email with the new password
            if (sendEmailToResident($email, $newPassword)) {
                echo "Password reset email sent successfully.";
            } else {
                echo "Failed to send email. Please try again later.";
            }
        } else {
            echo "Failed to update the password in the database.";
        }
    } else {
        echo "Email not found in the database.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
