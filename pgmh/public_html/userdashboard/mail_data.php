<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'resident') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Database credentials for residents_ticket
$residents_dbname = "u614894444_pgmhdb";
$residents_conn = new mysqli("localhost", "u614894444_pdmh", "P0531d0n321", $residents_dbname);

if ($residents_conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Residents database connection failed: ' . $residents_conn->connect_error]);
    exit();
}

// Query for completed reservations
$sql_reservations = "SELECT id, name, email, date, starttime, endtime, activity, created_at, completed_at, admin_name, edited, message 
                     FROM reservations 
                     WHERE status = 'completed'";

// Query for completed maintenance requests
$sql_maintenance = "SELECT id, name, location, type, created_at, status, admin_name 
                    FROM maintenance 
                    WHERE status = 'completed'";

// Query for visitor approvals or denials
$sql_visitors = "SELECT visitor_name, contact_number, resident_name, visit_date, visit_time, status, created_at, confirmed_at
                 FROM visitor 
                 WHERE status IN ('approved', 'denied')";

// Execute queries
$result_reservations = $residents_conn->query($sql_reservations);
$result_maintenance = $residents_conn->query($sql_maintenance);
$result_visitors = $residents_conn->query($sql_visitors);

if ($result_reservations === false || $result_maintenance === false || $result_visitors === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Query error: ' . $residents_conn->error]);
    $residents_conn->close();
    exit();
}

// Process reservations
$reservations = [];
while ($row = $result_reservations->fetch_assoc()) {
    $notification_message = isset($row['edited']) && $row['edited'] == 'true'
        ? htmlspecialchars($row['message'])
        : "Your reservation for " . htmlspecialchars($row['activity']) . " on " . htmlspecialchars($row['date']) . " at " . htmlspecialchars($row['starttime']) . " to " . htmlspecialchars($row['endtime']) . " is confirmed.";
    $row['notification_message'] = $notification_message;
    $reservations[] = $row;
}

// Process maintenance requests
$maintenance_requests = [];
while ($row = $result_maintenance->fetch_assoc()) {
    $notification_message = "Your maintenance request for " . htmlspecialchars($row['type']) . " at " . htmlspecialchars($row['location']) . " has been confirmed.";
    $completed_at = isset($row['completed_at']) ? $row['completed_at'] : date('Y-m-d H:i:s');
    $row['notification_message'] = $notification_message;
    $row['completed_at'] = $completed_at;
    $maintenance_requests[] = $row;
}

// Process visitor approvals/denials
$visitor_requests = [];
while ($row = $result_visitors->fetch_assoc()) {
    $notification_message = "Visitor request for " . htmlspecialchars($row['visitor_name']) . " (" . htmlspecialchars($row['contact_number']) . "), scheduled for " . htmlspecialchars($row['visit_date']) . " at " . htmlspecialchars($row['visit_time']) . " has been " . htmlspecialchars($row['status']) . ".";
    $confirmed_at = isset($row['confirmed_at']) ? $row['confirmed_at'] : date('Y-m-d H:i:s');
    $row['notification_message'] = $notification_message;
    $row['confirmed_at'] = $confirmed_at;
    $visitor_requests[] = $row;
}

// Combine all notifications
$notifications = array_merge($reservations, $maintenance_requests, $visitor_requests);

// Return as JSON
echo json_encode($notifications);
$residents_conn->close();
?>
