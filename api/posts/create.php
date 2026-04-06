<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id'])) {
    sendJsonResponse('error', 'Unauthorized. Please login first.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $title = isset($data->title) ? trim($data->title) : '';
    $content = isset($data->content) ? trim($data->content) : '';
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($content)) {
        sendJsonResponse('error', 'Title and content are required.');
    }

    $stmt = $conn->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $content, $user_id);

    if ($stmt->execute()) {
        sendJsonResponse('success', 'Post created successfully.', ['id' => $stmt->insert_id]);
    } else {
        sendJsonResponse('error', 'Failed to create post.');
    }
    $stmt->close();
} else {
    sendJsonResponse('error', 'Invalid request method.');
}
$conn->close();
?>
