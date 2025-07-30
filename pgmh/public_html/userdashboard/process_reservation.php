<?php
header('Content-Type: application/json');
session_start();

// Database connection
$servername = "localhost";
$username = "u614894444_pdmh";
$password = "P0531d0n321";
$dbname = "u614894444_pgmhdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit();
}

// Retrieve resident's full name from session
if (!isset($_SESSION['full_name'])) {
    echo json_encode(["success" => false, "message" => "User is not logged in."]);
    exit();
}
$residentName = $_SESSION['full_name'];

// Get form data
$email = $_POST['inputEmail'];
$date = date('Y-m-d', strtotime($_POST['inputDate']));
$activity = $_POST['inputActivity'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];

// Validate the email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email format."]);
    exit();
}

// Accompanying people
$people = $_POST['people'];
$contacts = $_POST['contacts'];

$accompanyingPeople = [];
for ($i = 0; $i < count($people); $i++) {
    $accompanyingPeople[] = [
        "name" => $people[$i],
        "email" => $contacts[$i]
    ];
}
$accompanyingPeopleJson = json_encode($accompanyingPeople);

// `created_at` timestamp
$createdAt = date('Y-m-d H:i:s');

// Check if a reservation already exists
$stmt_check = $conn->prepare(
    "SELECT * FROM reservations 
     WHERE date = ? AND activity = ? AND (
        (starttime <= ? AND endtime > ?) OR 
        (starttime < ? AND endtime >= ?)
    )"
);
$stmt_check->bind_param("ssssss", $date, $activity, $startTime, $startTime, $endTime, $endTime);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "A reservation for the same time and activity already exists."]);
} else {
    $stmt = $conn->prepare(
        "INSERT INTO reservations 
         (name, email, date, activity, starttime, endtime, accompanying_people, created_at, status) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')"
    );
    $stmt->bind_param(
        "ssssssss", 
        $residentName, $email, $date, $activity, $startTime, $endTime, 
        $accompanyingPeopleJson, $createdAt
    );

    if ($stmt->execute()) {
        sendEmailNotification($email, $residentName, $date, $activity, $startTime, $endTime);
        echo json_encode(["success" => true, "message" => "Reservation made successfully!"]);
    } else {
        error_log("Error: " . $stmt->error);
        echo json_encode(["success" => false, "message" => "Reservation could not be made. Please try again later."]);
    }

    $stmt->close();
}

$stmt_check->close();
$conn->close();

// Function to send email
function sendEmailNotification($toEmail, $toName, $date, $activity, $startTime, $endTime, $accompanyingPeopleJson) {
    $fromEmail = "pgmhonline@pgmh.online";
    $fromName = "PGMH Admin";

    // Decode accompanying people JSON
    $accompanyingPeopleArray = json_decode($accompanyingPeopleJson, true);

    // Generate the accompanying people list in HTML format
    $accompanyingPeopleList = "";
    if (!empty($accompanyingPeopleArray)) {
        foreach ($accompanyingPeopleArray as $person) {
            $accompanyingPeopleList .= "<li>" . htmlspecialchars($person['name']) . " (" . htmlspecialchars($person['email']) . ")</li>";
        }
    }

    $subject = "Reservation Confirmation";
    $message = "
        <html>
        <head>
            <title>Reservation Confirmation</title>
        </head>
        <body>
            <p>Dear $toName,</p>
            <p>Thank you for your reservation at PGMH. Here are your reservation details:</p>
            <p><strong>Date:</strong> $date<br>
            <strong>Activity:</strong> $activity<br>
            <strong>Start Time:</strong> $startTime<br>
            <strong>End Time:</strong> $endTime</p>";

    if (!empty($accompanyingPeopleList)) {
        $message .= "
            <p><strong>Accompanying People:</strong></p>
            <ul>$accompanyingPeopleList</ul>";
    }

    $message .= "
            <p>Your reservation is currently pending confirmation. We will notify you once it is confirmed.</p>
            <p>Best regards,<br>PGMH Team</p>
        </body>
        </html>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $fromName <$fromEmail>" . "\r\n";

    if (!mail($toEmail, $subject, $message, $headers)) {
        error_log("Email sending failed to $toEmail");
    }
}

?>
