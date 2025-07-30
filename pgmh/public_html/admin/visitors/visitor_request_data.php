<?php
session_start();

// Get the logged-in admin's name from the session
$full_name = $_SESSION['full_name'];

// Database configuration
$servername = "localhost"; 
$username = "u614894444_pdmh"; 
$password = "P0531d0n321"; 
$database = "u614894444_pgmhdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the query to fetch visitor requests
$query = "SELECT * FROM visitor"; // Replace 'visitor_requests' with your actual table name
$result = $conn->query($query);

if ($result) {
    // Iterate through the result set and generate table rows
    while ($row = $result->fetch_assoc()) {
        // Escape output for security
        $visitor_name = htmlspecialchars($row['visitor_name']);
        $visitor_email = htmlspecialchars($row['visitor_email']);
        $contact_number = htmlspecialchars($row['contact_number']);
        $resident_name = htmlspecialchars($row['resident_name']);
        $visit_date = htmlspecialchars($row['visit_date']);
        $visit_time = htmlspecialchars($row['visit_time']);
        $purpose_of_visit = htmlspecialchars($row['purpose_of_visit']);
        $created_at = htmlspecialchars($row['created_at']);
        $confirmed_at = htmlspecialchars($row['confirmed_at']);
        $status = htmlspecialchars($row['status']);

        // Output each row in the table
        echo "<tr>
                <td>$visitor_name</td>
                <td>$visitor_email</td>
                <td>$contact_number</td>
                <td>$resident_name</td>
                <td>$visit_date</td>
                <td>$visit_time</td>
                <td>$purpose_of_visit</td>
                <td>$created_at</td>
                <td>$confirmed_at</td>
                <td>$status</td>
                <td><button class='btn btn-primary' onclick='confirmBtn($row[id])'>Confirm</button></td>
                <td><button class='btn btn-danger' onclick='denyBtn($row[id])'>Deny</button></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='11'>No data found</td></tr>";
}

$conn->close();
?>
