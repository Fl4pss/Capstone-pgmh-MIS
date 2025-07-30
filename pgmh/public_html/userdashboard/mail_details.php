<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'resident') {
    header("Location: index.html");
    exit();
}

require 'db_connection.php'; // Your database connection

if (!isset($_GET['id'])) {
    echo "No mail ID provided.";
    exit();
}

$mail_id = intval($_GET['id']);
$sql = "SELECT * FROM notifications WHERE id = ? AND resident_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mail_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $mail = $result->fetch_assoc();
    // Display mail details
} else {
    echo "Mail not found or you do not have access.";
}
?>
