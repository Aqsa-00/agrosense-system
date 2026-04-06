<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id'])) {
    sendJsonResponse('error', 'Unauthorized. Please login first.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $post_id = isset($data->post_id) ? intval($data->post_id) : 0;
    $comment = isset($data->comment) ? trim($data->comment) : '';
    $user_id = $_SESSION['user_id'];

    if ($post_id <= 0 || empty($comment)) {
        sendJsonResponse('error', 'Post ID and comment are required.');
    }

    $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $post_id, $user_id, $comment);

    if ($stmt->execute()) {
        sendJsonResponse('success', 'Comment added successfully.', ['id' => $stmt->insert_id]);
    } else {
        sendJsonResponse('error', 'Failed to add comment.');
    }
    $stmt->close();
} else {
    sendJsonResponse('error', 'Invalid request method.');
}
$conn->close();
?>
