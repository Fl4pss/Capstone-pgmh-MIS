<?php
header('Content-Type: application/json');
session_start();  // Start the session (still needed for other session-related tasks)

// Database connection
$servername = "localhost";
$username = "u614894444_pdmh";
$password = "P0531d0n321";
$dbname = "u614894444_pgmhdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit();
}

// Retrieve the resident's full name from the form (ensure this field exists in the form)
if (!isset($_POST['inputName']) || empty($_POST['inputName'])) {
    echo json_encode(["success" => false, "message" => "Resident name is required."]);
    exit();
}
$residentName = $_POST['inputName'];  // Resident's name from the input field

// Get form data
$email = $_POST['inputEmail'];
$date = date('Y-m-d', strtotime($_POST['inputDate']));  // Date in Y-m-d format
$activity = $_POST['inputActivity'];
$startTime = $_POST['startTime'];  // Time in 12-hour format (e.g., '9 AM')
$endTime = $_POST['endTime'];      // Time in 12-hour format (e.g., '10 PM')

// Validate the email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email format."]);
    exit();
}

// Accompanying people (names and emails)
$people = $_POST['people'];  // Array of accompanying people's names
$emails = $_POST['emails'];  // Array of accompanying people's emails

// Prepare accompanying people data for storage
$accompanyingPeople = [];
for ($i = 0; $i < count($people); $i++) {
    $accompanyingPeople[] = [
        "name" => $people[$i],
        "email" => $emails[$i]
    ];
}
$accompanyingPeopleJson = json_encode($accompanyingPeople);

// `created_at` timestamp (current time)
$createdAt = date('Y-m-d H:i:s');

// Check if a reservation for the same date, activity, and time range exists
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
    // Insert reservation into the database
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
        echo json_encode(["success" => true, "message" => "Reservation made successfully!"]);
    } else {
        error_log("Error: " . $stmt->error);
        echo json_encode(["success" => false, "message" => "Reservation could not be made. Please try again later."]);
    }

    $stmt->close();
}

$stmt_check->close();
$conn->close();
?>
