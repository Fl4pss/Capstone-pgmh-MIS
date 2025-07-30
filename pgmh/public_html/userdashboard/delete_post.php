<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = (int)$_POST['post_id'];
    $user_id = $_SESSION['user_id']; // Ensure the user is authenticated.

    // Verify the post belongs to the user or allow admins to delete any post.
    $stmt = $conn->prepare("DELETE FROM forum_posts WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Post deleted successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete the post."]);
    }

    $stmt->close();
    $conn->close();
}
?>
