<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "residents_ticket";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to fetch current announcements
function getCurrentAnnouncements($conn) {
    $sql = "SELECT * FROM announcements WHERE status = 'active'";
    $result = mysqli_query($conn, $sql);

    $announcements = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $announcements[] = $row;
        }
    }

    return $announcements;
}

// Fetch data based on requested action
$action = $_GET['action'];

if ($action == 'getCurrentAnnouncements') {
    $currentAnnouncements = getCurrentAnnouncements($conn);
    echo json_encode($currentAnnouncements);
}

// Close database connection
mysqli_close($conn);
?>
