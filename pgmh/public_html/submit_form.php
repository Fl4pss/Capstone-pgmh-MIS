<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contactNumber'];
    $subject = $_POST['subject'];
    $subject = ($subject == 'other') ? $_POST['otherSubject'] : $subject;
    $message = $_POST['message'];
    
    // Validate form data
    if (!empty($fullName) && !empty($email) && !empty($message)) {
        // Database connection parameters
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "visitor_tickets";
        
        // Create database connection
        $conn = new mysqli($host, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            echo "Connection failed: " . $conn->connect_error;
            exit;
        }
        
        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO tickets (fullName, email, contactNumber, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fullName, $email, $contactNumber, $subject, $message);
        
        // Execute SQL statement
        if ($stmt->execute() === TRUE) {
            echo "success";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
    } else {
        echo "Please fill in all required fields.";
    }
} else {
    echo "Form submission method not allowed.";
}
?>
