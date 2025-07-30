<?php
// Connect to your database (replace these values with your actual database credentials)
$servername = "localhost";
$username = "u614894444_pdmh";
$password = "P0531d0n321";
$dbname = "u614894444_pgmhdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count the number of announcements
$sqlAnnouncements = "SELECT COUNT(id) AS announcementCount FROM announcements";
$resultAnnouncements = $conn->query($sqlAnnouncements);

// Query to count the number of maintenance announcements
$sqlMaintenance = "SELECT COUNT(id) AS maintenanceCount FROM maintenance";
$resultMaintenance = $conn->query($sqlMaintenance);

// Initialize variables for counts
$announcementCount = 0;
$maintenanceCount = 0;

// Fetch the count of announcements
if ($resultAnnouncements->num_rows > 0) {
    $rowAnnouncements = $resultAnnouncements->fetch_assoc();
    $announcementCount = $rowAnnouncements["announcementCount"];
}

// Fetch the count of maintenance announcements
if ($resultMaintenance->num_rows > 0) {
    $rowMaintenance = $resultMaintenance->fetch_assoc();
    $maintenanceCount = $rowMaintenance["maintenanceCount"];
}

// Total count is the sum of both counts
$totalCount = $announcementCount + $maintenanceCount;

$conn->close();

// Output the total count
echo $totalCount;
?>
