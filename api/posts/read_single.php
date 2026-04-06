<?php
require_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($id <= 0) {
        sendJsonResponse('error', 'Invalid post ID');
    }

    $stmt = $conn->prepare("SELECT p.id, p.title, p.content, p.created_at, u.name as author, p.user_id 
                            FROM posts p 
                            JOIN users u ON p.user_id = u.id 
                            WHERE p.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        sendJsonResponse('success', 'Post fetched', $row);
    } else {
        sendJsonResponse('error', 'Post not found');
    }

    $stmt->close();
} else {
    sendJsonResponse('error', 'Invalid request method.');
}
$conn->close();
?>
