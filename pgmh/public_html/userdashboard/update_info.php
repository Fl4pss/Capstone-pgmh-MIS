<?php
// Include the database connection file
include_once 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input fields
    $email = $_POST['email'];
    $contactNumber = $_POST['contactNumber'];
    $birthday = $_POST['birthday'];
    
    // Prepare SQL statement to update the database
    $sql = "UPDATE residents SET email = ?, contact_number = ?, birthday = ? WHERE id = ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters and execute the statement
    $stmt->bind_param("sssi", $email, $contactNumber, $birthday, $userId); 
    $stmt->execute();
    
    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        echo "Information updated successfully.";
    } else {
        echo "Error updating information: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
    
    // Close the database connection
    $conn->close();
}
?>
