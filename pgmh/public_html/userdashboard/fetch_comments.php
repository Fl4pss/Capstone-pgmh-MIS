<?php
require 'db_connection.php';

if (!isset($_GET['post_id']) || !filter_var($_GET['post_id'], FILTER_VALIDATE_INT)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid or missing post_id'
    ]);
    exit;
}

$postId = intval($_GET['post_id']);

$query = "SELECT comments.id, comments.content, users.full_name AS author, comments.created_at
          FROM forum_comments AS comments
          JOIN users ON comments.user_id = users.id
          WHERE comments.post_id = ?
          ORDER BY comments.created_at";

$stmt = $conn->prepare($query);
if ($stmt === false) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to prepare the statement.'
    ]);
    exit;
}

$stmt->bind_param('i', $postId);
if (!$stmt->execute()) {
    echo json_encode([
        'success' => false,
        'message' => 'Query execution failed.'
    ]);
    exit;
}

$result = $stmt->get_result();
$comments = $result->fetch_all(MYSQLI_ASSOC);

$html = '<div>';
foreach ($comments as $comment) {
    // Format the comment with the author's name and the time ago
    $timeAgo = time_ago($comment['created_at']);  // Helper function for time formatting
    $html .= "<div class='comment'>
                <strong>{$comment['author']}</strong> <small>({$timeAgo})</small>
                <p>{$comment['content']}</p>
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
    'html' => $html
]);

/**
 * Helper function to calculate the time ago format.
 */
function time_ago($timestamp) {
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    
    $minutes      = round($seconds / 60);           // value 60 is seconds
    $hours        = round($seconds / 3600);         // value 3600 is 60 minutes * 60 sec
    $days         = round($seconds / 86400);        // value 86400 is 24 hours * 60 minutes * 60 sec
    $weeks        = round($seconds / 604800);       // value 604800 is 7 days * 24 hours * 60 minutes * 60 sec
    $months       = round($seconds / 2629440);      // value 2629440 is ((365+365+365+365+365)/5/12) days * 24 hours * 60 minutes * 60 sec
    $years        = round($seconds / 31553280);     // value 31553280 is (365+365+365+365+365)/5 days * 24 hours * 60 minutes * 60 sec
    
    if ($seconds <= 60) {
        return "Just Now";
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "one minute ago";
        } else {
            return "$minutes minutes ago";
        }
    } else if ($hours <= 24) {
        if ($hours == 1) {
            return "an hour ago";
        } else {
            return "$hours hrs ago";
        }
    } else if ($days <= 7) {
        if ($days == 1) {
            return "yesterday";
        } else {
            return "$days days ago";
        }
    } else if ($weeks <= 4.3) { // 4.3 == 30/7
        if ($weeks == 1) {
            return "a week ago";
        } else {
            return "$weeks weeks ago";
        }
    } else if ($months <= 12) {
        if ($months == 1) {
            return "one month ago";
        } else {
            return "$months months ago";
        }
    } else {
        if ($years == 1) {
            return "one year ago";
        } else {
            return "$years years ago";
        }
    }
}
?>
