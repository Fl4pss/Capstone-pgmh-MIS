<?php
session_start();
require_once 'db_connection.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'resident') {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Get the logged-in resident's name from the session
$full_name = $_SESSION['full_name'];

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch completed maintenance tickets for the logged-in user
    $query = "SELECT * FROM maintenance WHERE name = :full_name AND status = 'completed'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results); // Send the data as JSON to the frontend
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
