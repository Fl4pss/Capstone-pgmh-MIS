<?php
session_start();

if (!isset($_SESSION['admin_name']) || empty($_SESSION['admin_name'])) {
    error_log("Warning: 'admin_name' is not set in the session.");
} else {
    error_log("Session 'admin_name': " . $_SESSION['admin_name']);
}

$admin_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Unknown';

$servername = "localhost";
$username = "u614894444_pdmh";
$password = "P0531d0n321";
$dbname = "u614894444_pgmhdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to insert a notification into the notifications table
function insertNotification($conn, $ticketData, $admin_name) {
    $sql = "INSERT INTO notifications (ticket_id, name, location, email, type, other_issue, status, created_at, completed_at, admin_name, notification_message)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $notification_message = "Ticket ID {$ticketData['id']} has been updated to status '{$ticketData['status']}' by admin '{$admin_name}'.";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param(
            "issssssssss",
            $ticketData['id'],
            $ticketData['name'],
            $ticketData['location'],
            $ticketData['email'],
            $ticketData['type'],
            $ticketData['other_issue'],
            $ticketData['status'],
            $ticketData['created_at'],
            $ticketData['completed_at'],
            $admin_name,
            $notification_message
        );
        $stmt->execute();
        $stmt->close();
    } else {
        error_log("Failed to prepare notification statement: " . $conn->error);
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = array();
    $id = intval($_POST['id']);
    $action = $_POST['action'];
    $status = $action === 'archive' ? 'Archived' : 'Completed';
    
    if ($action === 'done') {
        // Check if urgency was passed for update
        $urgency = isset($_POST['urgency']) ? $_POST['urgency'] : null;
        
        $stmt = $conn->prepare("UPDATE maintenance SET status=?, completed_at=NOW(), admin_name=? WHERE id=?");
        
        if ($stmt) {
            $stmt->bind_param("ssi", $status, $admin_name, $id);
            if ($stmt->execute()) {
                if ($urgency) {
                    // Update urgency if it was passed
                    $updateUrgencyStmt = $conn->prepare("UPDATE maintenance SET urgency=? WHERE id=?");
                    if ($updateUrgencyStmt) {
                        $updateUrgencyStmt->bind_param("si", $urgency, $id);
                        $updateUrgencyStmt->execute();
                        $updateUrgencyStmt->close();
                    } else {
                        error_log("Error preparing urgency update: " . $conn->error);
                    }
                }

                $response['status'] = 'success';
                error_log("Ticket ID $id updated with status '$status' and urgency '$urgency' by admin '$admin_name'");

                // Fetch the updated ticket data
                $ticketResult = $conn->query("SELECT id, name, location, type, other_issue, status, created_at, completed_at, urgency FROM maintenance WHERE id = $id");
                if ($ticketResult && $ticketResult->num_rows > 0) {
                    $ticketData = $ticketResult->fetch_assoc();
                    $ticketData['status'] = $status;
                    $ticketData['completed_at'] = date("Y-m-d H:i:s");  // Current timestamp

                    // Insert notification
                    insertNotification($conn, $ticketData, $admin_name);
                }
            } else {
                $response['status'] = 'error';
                error_log("Error executing update for ticket ID $id: " . $stmt->error);
            }
            $stmt->close();
        } else {
            $response['status'] = 'error';
            error_log("Failed to prepare statement for updating ticket ID $id: " . $conn->error);
        }
    } elseif ($action === 'archive') {
        $stmt = $conn->prepare("UPDATE maintenance SET status='Archived', admin_name=? WHERE id=?");

        if ($stmt) {
            $stmt->bind_param("si", $admin_name, $id);
            if ($stmt->execute()) {
                $response['status'] = 'success';
                error_log("Ticket ID $id archived by admin '$admin_name'");

                // Fetch the updated ticket data
                $ticketResult = $conn->query("SELECT id, name, location, type, other_issue, status, created_at, completed_at FROM maintenance WHERE id = $id");
                if ($ticketResult && $ticketResult->num_rows > 0) {
                    $ticketData = $ticketResult->fetch_assoc();
                    $ticketData['status'] = 'Archived';
                    $ticketData['completed_at'] = date("Y-m-d H:i:s");  // Current timestamp

                    // Insert notification
                    insertNotification($conn, $ticketData, $admin_name);
                }
            } else {
                $response['status'] = 'error';
                error_log("Error executing update for ticket ID $id: " . $stmt->error);
            }
            $stmt->close();
        } else {
            $response['status'] = 'error';
            error_log("Failed to prepare statement for archiving ticket ID $id: " . $conn->error);
        }
    }

    echo json_encode($response);
    $conn->close();
    exit;
}

function fetchActiveAndArchivedTickets($conn, $urgency = null) {
    $sql = "SELECT id, name, description, location, urgency, type, other_issue, status, created_at, 
                   completed_at, email, TO_BASE64(image) as image 
            FROM maintenance 
            WHERE status='Pending' OR status='Archived'";
    if ($urgency) {
        $sql .= " AND urgency='$urgency'";
    }

    $result = $conn->query($sql);
    $tickets = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tickets[] = $row;
        }
    }
    return $tickets;
}



function fetchCompletedTickets($conn) {
    $sql = "SELECT id, name, description, location, urgency, type, other_issue, status, created_at, 
                   completed_at, admin_name, email, TO_BASE64(image) as image 
            FROM maintenance 
            WHERE status='Completed'";
    $result = $conn->query($sql);

    $completed_tickets = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $completed_tickets[] = $row;
        }
    }
    return $completed_tickets;
}


$urgency = isset($_GET['urgency']) ? $_GET['urgency'] : null;
$active_and_archived_tickets = fetchActiveAndArchivedTickets($conn, $urgency);
$completed_tickets = fetchCompletedTickets($conn);

$conn->close();
echo json_encode(array(
    'active_and_archived_tickets' => $active_and_archived_tickets,
    'completed_tickets' => $completed_tickets
));

?>
