<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'User is not logged in.'
        ]);
        exit;
    }

    $postId = $_POST['post_id'] ?? null;
    $content = $_POST['content'] ?? null;
    $userId = $_SESSION['user_id']; // Safe to access after validation

    if (!$postId || !$content) {
        echo json_encode([
            'success' => false,
            'message' => 'Post ID and content are required.'
        ]);
        exit;
    }

    // Insert the comment into the database
    $query = "INSERT INTO forum_comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to prepare the statement.'
        ]);
        exit;
    }

    $stmt->bind_param('iis', $postId, $userId, $content);

    if ($stmt->execute()) {
        // Fetch the latest comments after successful insertion
        $query = "SELECT comments.id, comments.content, users.full_name AS author, comments.created_at
                  FROM forum_comments AS comments
                  JOIN users ON comments.user_id = users.id
                  WHERE comments.post_id = ?
                  ORDER BY comments.created_at";

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to prepare the query to fetch comments.'
            ]);
            exit;
        }

        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $result = $stmt->get_result();
        $comments = $result->fetch_all(MYSQLI_ASSOC);

        // Define the timeAgo function to format the time
        function timeAgo($datetime) {
            $time = strtotime($datetime);
            $diff = time() - $time;

            if ($diff < 60) {
                return $diff . ' secs ago';
            } elseif ($diff < 3600) {
                return floor($diff / 60) . ' mins ago';
            } elseif ($diff < 86400) {
                return floor($diff / 3600) . ' hrs ago';
            } else {
                return floor($diff / 86400) . ' days ago';
            }
        }

        // Generate HTML for the comments with the time
        $html = '<div>';
        foreach ($comments as $comment) {
            $timeAgo = timeAgo($comment['created_at']); // Format time
            $html .= "<div class='comment'>
                        <strong>{$comment['author']}</strong>
                        <p>{$comment['content']}</p>
                        <small><i>{$timeAgo}</i></small> <!-- Time ago added here -->
                      </div>";
        }
        $html .= '
            <form id="commentForm" class="mt-3">
                <textarea class="form-control mb-2" name="content" placeholder="Write a comment..." required></textarea>
                <button type="submit" class="btn btn-primary btn-sm">Post Comment</button>
                <input type="hidden" name="post_id" value="' . $postId . '">
            </form>
        </div>';

        echo json_encode([
            'success' => true,
            'message' => 'Comment added successfully!',
            'html' => $html
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add the comment.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>
