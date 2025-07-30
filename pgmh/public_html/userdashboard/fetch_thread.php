<?php
require 'db_connection.php';

$commentId = $_GET['comment_id'];

$query = "SELECT thread.content, users.full_name AS author
          FROM comment_threads AS thread
          JOIN users ON thread.user_id = users.id
          WHERE thread.comment_id = ?
          ORDER BY thread.created_at";

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $commentId);
$stmt->execute();
$result = $stmt->get_result();

$threads = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($threads);
?>
