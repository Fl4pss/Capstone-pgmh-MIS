<?php
include_once 'db_connection.php'; // Include database connection file

// Fetch data from the database
$sql = "SELECT * FROM tickets"; // SQL query to fetch data
$result = $conn->query($sql); // Execute the query

if ($result->num_rows > 0) { // Check if there are any rows returned
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["subject"] . "</td>
                <td>" . $row["fullName"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>" . $row["contactNumber"] . "</td>
                <td>" . $row["message"] . "</td>
                <td>" . $row["created_at"] . "</td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No data found</td></tr>"; // Display message if no data found
}

$conn->close(); // Close the database connection
?>
