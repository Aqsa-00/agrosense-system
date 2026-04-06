<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT p.id, p.title, SUBSTRING(p.content, 1, 150) as preview, p.created_at, u.name as author 
            FROM posts p 
            JOIN users u ON p.user_id = u.id 
            ORDER BY p.created_at DESC";
    
    $result = $conn->query($sql);
    $posts = [];
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        sendJsonResponse('success', 'Posts fetched', $posts);
    } else {
        sendJsonResponse('success', 'No posts found', []);
    }
} else {
    sendJsonResponse('error', 'Invalid request method.');
}
$conn->close();
?>
