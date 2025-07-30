<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'like') {
    $post_id = intval($_POST['post_id']);
    $user_id = intval($_SESSION['user_id']);

    // Check if the user has already liked the post
    $checkLike = $conn->prepare("SELECT * FROM post_likes WHERE post_id = ? AND user_id = ?");
    $checkLike->bind_param("ii", $post_id, $user_id);
    $checkLike->execute();
    $likeResult = $checkLike->get_result();

    if ($likeResult->num_rows > 0) {
        // Unlike: Remove the like
        $deleteLike = $conn->prepare("DELETE FROM post_likes WHERE post_id = ? AND user_id = ?");
        $deleteLike->bind_param("ii", $post_id, $user_id);
        $deleteLike->execute();

        // Decrement the like count on the post
        $conn->query("UPDATE forum_posts SET likes = likes - 1 WHERE id = $post_id");

        echo json_encode(['status' => 'unliked']);
    } else {
        // Like: Add the like
        $addLike = $conn->prepare("INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)");
        $addLike->bind_param("ii", $post_id, $user_id);
        $addLike->execute();

        // Increment the like count on the post
        $conn->query("UPDATE forum_posts SET likes = likes + 1 WHERE id = $post_id");

        echo json_encode(['status' => 'liked']);
    }
}
?>
