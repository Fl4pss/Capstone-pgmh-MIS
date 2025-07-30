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

// Function to send email to the resident
function sendEmailToResident($toEmail, $toName, $rawPassword) {
    $fromEmail = "pgmhonline@pgmh.online"; // Replace with your Hostinger email
    $fromName = "PGMH Admin";

    $subject = "Welcome to PGMH!";
    $message = "
        <html>
        <head>
            <title>Welcome to PGMH!</title>
        </head>
        <body>
            <p>Dear $toName,</p>
            <p>Your account in PGMH has been created successfully. Below are your login details:</p>
            <p><strong>Email:</strong> $toEmail<br>
            <strong>Password:</strong> $rawPassword</p>
            <p>Thank you for being part of our community!</p>
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

// Get admin name and code from session
$admin_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : "Unknown";
$admin_code = isset($_SESSION['admin_code']) ? $_SESSION['admin_code'] : null; // Assuming admin_code is stored in session

// Get form data
$firstName = $conn->real_escape_string($_POST['inputFirstName']);
$middleName = $conn->real_escape_string($_POST['inputMiddleName']);
$lastName = $conn->real_escape_string($_POST['inputLastName']);
$email = $conn->real_escape_string($_POST['inputEmail']);
$contact = $conn->real_escape_string($_POST['inputContact']);
$unit = $conn->real_escape_string($_POST['inputUnit']);
$rawPassword = $_POST['inputPassword']; // Unhashed password to send in email
$password = password_hash($rawPassword, PASSWORD_BCRYPT); // Hash the password
$birthday = $conn->real_escape_string($_POST['inputBirthday']);
$fullName = $firstName . ' ' . $middleName . ' ' . $lastName; // Concatenate the full name
$created_at = date('Y-m-d H:i:s'); // Current timestamp

// Insert into residents table
$sql = "INSERT INTO residents (first_name, middle_name, last_name, email, contact_number, unit_number, password, birthday)
        VALUES ('$firstName', '$middleName', '$lastName', '$email', '$contact', '$unit', '$password', '$birthday')";

if ($conn->query($sql) === TRUE) {
    $resident_id = $conn->insert_id; // Get the last inserted ID from residents table
    
    // Insert into users table
    $user_type = 'resident';
    $sql_user = "INSERT INTO users (email, password, full_name, resident_id, created_at, unit_number, user_type)
                 VALUES ('$email', '$password', '$fullName', '$resident_id', '$created_at', '$unit', '$user_type')";
    
    if ($conn->query($sql_user) === TRUE) {
        // Send email to the resident
        if (sendEmailToResident($email, $fullName, $rawPassword)) {
            // Redirect back to the form with success message
            header("Location: residents_registration.php?status=success");
            exit();
        } else {
            // Redirect back to the form with email error message
            header("Location: residents_registration.php?status=error&message=" . urlencode("Error sending welcome email."));
            exit();
        }
    } else {
        // Redirect back to the form with error message for users table insertion
        header("Location: residents_registration.php?status=error&message=" . urlencode("Error inserting into users table: " . $conn->error));
        exit();
    }
} else {
    // Redirect back to the form with error message for residents table insertion
    header("Location: residents_registration.php?status=error&message=" . urlencode("Error inserting into residents table: " . $conn->error));
    exit();
}

$conn->close();
?>
