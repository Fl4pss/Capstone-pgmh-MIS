<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $content = $_POST['content'] ?? '';
    $image = null;

    if (!$user_id || empty($content)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
        exit();
    }

    // Fetch the user's full name
    $stmt = $conn->prepare("SELECT full_name FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'User not found.']);
        exit();
    }

    $stmt->bind_result($full_name);
    $stmt->fetch();

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file;
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload image.']);
            exit();
        }
    }

    // Insert post into the database, including the full_name
    $stmt = $conn->prepare("INSERT INTO forum_posts (user_id, content, image, full_name, created_at) VALUES (?, ?, ?, ?, CONVERT_TZ(NOW(), 'SYSTEM', '+08:00'))");
    $stmt->bind_param("isss", $user_id, $content, $image, $full_name);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Post created successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }
}
?>
