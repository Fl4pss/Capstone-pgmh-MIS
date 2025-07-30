<?php
// Database connection parameters
$host = 'localhost'; // Your MySQL host
$username = 'root'; // Your MySQL username
$password = ''; // Your MySQL password
$database = 'residents_ticket'; // Your MySQL database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the residents table
$sql = "SELECT id, full_name, email, contact_number, unit_number, birthday, created_at FROM residents";
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["full_name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["contact_number"] . "</td>";
        echo "<td>" . $row["unit_number"] . "</td>";
        echo "<td>" . $row["birthday"] . "</td>"; // Display the birthday
        echo "<td>" . $row["created_at"] . "</td>"; // Display the added date
        echo "<td><button class='btn btn-primary archive-btn' data-id='" . $row["id"] . "'>Archive</button></td>"; // Archive button
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>0 results</td></tr>"; // Update colspan to match new number of columns
}

// Close the database connection
$conn->close();
?>
