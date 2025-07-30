<?php
session_start();

// Database connection settings
$host = 'localhost';
$dbname = 'u614894444_pgmhdb';
$username = 'u614894444_pdmh';
$password = 'P0531d0n321';

function sendConfirmationEmail($toEmail, $toName, $activity, $date, $startTime, $endTime) {
    $fromEmail = "pgmhonline@pgmh.online"; // Replace with your email
    $fromName = "PGMH Admin";

    $subject = "Reservation Confirmation";
    $message = "
        <html>
        <head>
            <title>Reservation Confirmation</title>
        </head>
        <body>
            <p>Dear $toName,</p>
            <p>We are pleased to inform you that your reservation has been confirmed. Here are the details:</p>
            <p>
                <strong>Activity:</strong> $activity<br>
                <strong>Date:</strong> $date<br>
                <strong>Start Time:</strong> $startTime<br>
                <strong>End Time:</strong> $endTime
            </p>
            <p>Thank you for using our system!</p>
            <p>Best regards,<br>PGMH Team</p>
        </body>
        </html>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $fromName <$fromEmail>" . "\r\n";

    return mail($toEmail, $subject, $message, $headers);
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id']) && isset($data['action'])) {
            $reservationId = $data['id'];

            if ($data['action'] === 'confirm') {
                $adminName = $_SESSION['full_name'] ?? 'Unknown Admin';

                $stmt = $pdo->prepare("SELECT id, name, email, date, starttime, endtime, activity FROM reservations WHERE id = ?");
                $stmt->execute([$reservationId]);
                $reservationData = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($reservationData) {
                    $sql = "UPDATE reservations SET status = 'Completed', completed_at = NOW(), admin_name = ? WHERE id = ?";
                    $stmt = $pdo->prepare($sql);

                    if ($stmt->execute([$adminName, $reservationId])) {
                        // Send confirmation email
                        $emailSent = sendConfirmationEmail(
                            $reservationData['email'],
                            $reservationData['name'],
                            $reservationData['activity'],
                            $reservationData['date'],
                            $reservationData['starttime'],
                            $reservationData['endtime']
                        );

                        if ($emailSent) {
                            echo json_encode(['success' => true, 'message' => 'Reservation confirmed and email sent']);
                        } else {
                            echo json_encode(['success' => true, 'message' => 'Reservation confirmed but email failed to send']);
                        }
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to confirm reservation']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Reservation not found']);
                }
                exit();
            }

            // Handle archiving the reservation
            if ($data['action'] === 'archive') {
                // Get the current logged-in admin's name from session
                $adminName = $_SESSION['full_name'] ?? 'Unknown Admin';
            
                // Archive the reservation and retrieve its details
                $sql = "UPDATE reservations SET status = 'archived', admin_name = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
            
                if ($stmt->execute([$adminName, $reservationId])) {
                    // Fetch the archived reservation details
                    $stmt = $pdo->prepare("SELECT id, name, email, date, starttime AS start_time, endtime AS end_time, activity, accompanying_people, created_at, status, admin_name FROM reservations WHERE id = ?");
                    $stmt->execute([$reservationId]);
                    $archivedReservation = $stmt->fetch(PDO::FETCH_ASSOC);
            
                    // Decode accompanying_people JSON field
                    $archivedReservation['accompanying_people'] = json_decode($archivedReservation['accompanying_people'], true);
            
                    echo json_encode(['success' => true, 'reservation' => $archivedReservation]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to archive reservation']);
                }
                exit();
            }
            
        }

        // Validate input data for time update
        if (isset($data['id'], $data['start_time'], $data['end_time'], $data['reason'])) {
            $reservationId = $data['id'];
            $startTime = $data['start_time'];
            $endTime = $data['end_time'];
            $message = $data['reason'];

            // Update reservation times, message, and set edited to true
            $sql = "UPDATE reservations SET starttime = ?, endtime = ?, message = ?, edited = 'true' WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$startTime, $endTime, $message, $reservationId])) {
                // Fetch the updated reservation data
                $stmt = $pdo->prepare("SELECT starttime AS start_time, endtime AS end_time, message FROM reservations WHERE id = ?");
                $stmt->execute([$reservationId]);
                $updatedData = $stmt->fetch(PDO::FETCH_ASSOC);

                // Return updated times and message as JSON
                echo json_encode(['success' => true, 'updatedData' => $updatedData]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update reservation']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid input data']);
        }
        exit();
    }

    // Handle GET request to fetch reservations data
    $stmtActive = $pdo->prepare("SELECT id, name, email, date, starttime AS start_time, endtime AS end_time, activity, accompanying_people, created_at, status FROM reservations WHERE status != 'Completed' AND status != 'archived'");
    $stmtActive->execute();
    $activeReservations = $stmtActive->fetchAll(PDO::FETCH_ASSOC);

    $stmtCompleted = $pdo->prepare("SELECT id, name, email, date, starttime AS start_time, endtime AS end_time, activity, accompanying_people, created_at, status, completed_at, message, admin_name FROM reservations WHERE status = 'Completed'");
    $stmtCompleted->execute();
    $completedReservations = $stmtCompleted->fetchAll(PDO::FETCH_ASSOC);

    // Fetch archived reservations
    $stmtArchived = $pdo->prepare("SELECT id, name, email, date, starttime AS start_time, endtime AS end_time, activity, accompanying_people, created_at, status, admin_name FROM reservations WHERE status = 'archived'");
    $stmtArchived->execute();
    $archivedReservations = $stmtArchived->fetchAll(PDO::FETCH_ASSOC);

    // Decode accompanying_people JSON field
    foreach ($activeReservations as &$reservation) {
        $reservation['accompanying_people'] = json_decode($reservation['accompanying_people'], true);
    }

    foreach ($completedReservations as &$reservation) {
        $reservation['accompanying_people'] = json_decode($reservation['accompanying_people'], true);
    }

    foreach ($archivedReservations as &$reservation) {
        $reservation['accompanying_people'] = json_decode($reservation['accompanying_people'], true);
    }

    // Return reservation data as JSON
    echo json_encode([
        'active' => $activeReservations,
        'completed' => $completedReservations,
        'archived' => $archivedReservations,
    ]);

} catch (PDOException $e) {
    // Handle connection or query errors
    echo json_encode(['error' => $e->getMessage()]);
}
?>
