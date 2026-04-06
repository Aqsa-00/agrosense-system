<?php
require_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
    
    if ($post_id <= 0) {
        sendJsonResponse('error', 'Invalid post ID');
    }

    $stmt = $conn->prepare("SELECT c.id, c.comment, c.created_at, u.name as author, c.user_id 
                            FROM comments c 
                            JOIN users u ON c.user_id = u.id 
                            WHERE c.post_id = ? 
                            ORDER BY c.created_at ASC");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
    }
    sendJsonResponse('success', 'Comments fetched', $comments);
    $stmt->close();
} else {
    sendJsonResponse('error', 'Invalid request method.');
}
$conn->close();
?>
