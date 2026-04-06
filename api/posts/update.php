<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id'])) {
    sendJsonResponse('error', 'Unauthorized. Please login first.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $id = isset($data->id) ? intval($data->id) : 0;
    $title = isset($data->title) ? trim($data->title) : '';
    $content = isset($data->content) ? trim($data->content) : '';
    $user_id = $_SESSION['user_id'];

    if ($id <= 0 || empty($title) || empty($content)) {
        sendJsonResponse('error', 'ID, title and content are required.');
    }

    // Verify ownership
    $check_stmt = $conn->prepare("SELECT user_id FROM posts WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $post = $result->fetch_assoc();

    if (!$post) {
        sendJsonResponse('error', 'Post not found.');
    }

    if ($post['user_id'] !== $user_id) {
        sendJsonResponse('error', 'Unauthorized to update this post.');
    }
    $check_stmt->close();

    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $id);

    if ($stmt->execute()) {
        sendJsonResponse('success', 'Post updated successfully.');
    } else {
        sendJsonResponse('error', 'Failed to update post.');
    }
    $stmt->close();
} else {
    sendJsonResponse('error', 'Invalid request method.');
}
$conn->close();
?>
