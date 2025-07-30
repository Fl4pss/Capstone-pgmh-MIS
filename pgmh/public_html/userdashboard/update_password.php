<?php
session_start();
require_once 'db_connection.php'; // Include your database connection script

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'resident') {
    header("Location: ../index.html");
    exit();
}

// Get the current user's ID from the session
$user_id = $_SESSION['user_id'];

// Validate form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = trim($_POST['currentPassword']);
    $newPassword = trim($_POST['newPassword']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Validate input fields
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        die("All fields are required.");
    }

    // Check if new password matches the confirmation
    if ($newPassword !== $confirmPassword) {
        die("New password and confirmation do not match.");
    }

    // Fetch the current password from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (!$hashedPassword) {
        die("User not found.");
    }

    // Verify the current password
    if (!password_verify($currentPassword, $hashedPassword)) {
        die("Current password is incorrect.");
    }

    // Hash the new password before storing it
    $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Update the password in the database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $newHashedPassword, $user_id);

    if ($stmt->execute()) {
        echo "Password updated successfully.";
    } else {
        echo "Error updating password: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
