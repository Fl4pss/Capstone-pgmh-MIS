<?php
// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "residents_ticket";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate dropdown items
function generateDropdownItem($message, $imageUrl, $time, $dataMessage, $statusIndicator) {
    echo '<a class="dropdown-item d-flex align-items-center message-item" href="#" data-bs-toggle="modal" data-bs-target="#messageModal" data-message="' . $dataMessage . '">';
    echo '    <div class="dropdown-list-image mr-3">';
    echo '        <img class="rounded-circle" src="' . $imageUrl . '" alt="...">';
    echo '        <div class="status-indicator ' . $statusIndicator . '"></div>';
    echo '    </div>';
    echo '    <div>';
    echo '        <div class="text-truncate">' . $message . '</div>';
    echo '        <div class="small text-gray-500">Admin · ' . $time . '</div>';
    echo '    </div>';
    echo '</a>';
}

// Query to fetch maintenance tickets
$sqlMaintenance = "SELECT type, completed_at, status FROM maintenance WHERE status IN ('Completed', 'Archived') ORDER BY completed_at DESC";
$resultMaintenance = $conn->query($sqlMaintenance);

if ($resultMaintenance->num_rows > 0) {
    while ($row = $resultMaintenance->fetch_assoc()) {
        $message = ($row["status"] === "Completed") ? "Completed maintenance ticket for " : "Archived maintenance ticket for ";
        $dataMessage = $message . '"' . $row["type"] . '"';
        $time = date("h:i A", strtotime($row["completed_at"]));
        $imageUrl = "https://source.unsplash.com/random/60x60";
        $statusIndicator = "bg-success"; // Green indicator for maintenance

        generateDropdownItem($dataMessage, $imageUrl, $time, $dataMessage, $statusIndicator);
    }
}

// Query to fetch reservation tickets
$sqlReservations = "SELECT activity, completed_at, status FROM reservations WHERE status IN ('Completed', 'Archived') ORDER BY completed_at DESC";
$resultReservations = $conn->query($sqlReservations);

if ($resultReservations->num_rows > 0) {
    while ($row = $resultReservations->fetch_assoc()) {
        $message = ($row["status"] === "Completed") ? "Approved reservation ticket for " : "Archived reservation ticket for ";
        $dataMessage = $message . '"' . $row["activity"] . '"';
        $time = date("h:i A", strtotime($row["completed_at"]));
        $imageUrl = "https://source.unsplash.com/random/60x60";
        $statusIndicator = "bg-warning"; // Yellow indicator for reservations

        generateDropdownItem($dataMessage, $imageUrl, $time, $dataMessage, $statusIndicator);
    }
}

// Close the database connection
$conn->close();
?>
