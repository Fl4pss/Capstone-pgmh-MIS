<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');

    $servername = "localhost"; // Change if necessary
    $username = "root"; // Change if necessary
    $password = ""; // Change if necessary
    $dbname = "residents_ticket";

    $fullName = $_POST['fullName'];
    $email = $_POST['yourEmail'];
    $phone = $_POST['yourPhone'];
    $subject = $_POST['yourSubject'];
    if ($subject == "Other") {
        $subject = $_POST['otherSubject'];
    }
    $message = $_POST['yourMessage'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
        exit();
    }

    $sql = "INSERT INTO residents_mail (full_name, email, phone, subject, message)
            VALUES ('$fullName', '$email', '$phone', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "New record created successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
