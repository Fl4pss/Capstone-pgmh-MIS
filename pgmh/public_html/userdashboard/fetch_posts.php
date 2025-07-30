<?php
session_start();
require 'db_connection.php';

$user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session.

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

$query = "SELECT forum_posts.*, users.full_name AS author, 
                 CASE WHEN forum_posts.user_id = $user_id THEN 1 ELSE 0 END AS is_owner 
          FROM forum_posts 
          JOIN users ON forum_posts.user_id = users.id 
          ORDER BY forum_posts.created_at DESC";

$result = $conn->query($query);

$posts = [];
while ($row = $result->fetch_assoc()) {
    $row['time_ago'] = timeAgo($row['created_at']); // Add time ago format
    $posts[] = $row;
}

echo json_encode($posts);
?>
