<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id'])) {
    sendJsonResponse('error', 'Unauthorized. Please login first.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $id = isset($data->id) ? intval($data->id) : 0;
    $user_id = $_SESSION['user_id'];

    if ($id <= 0) {
        sendJsonResponse('error', 'Comment ID is required.');
    }

    // Verify ownership
    $check_stmt = $conn->prepare("SELECT user_id FROM comments WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $comment = $result->fetch_assoc();

    if (!$comment) {
        sendJsonResponse('error', 'Comment not found.');
    }

    if ($comment['user_id'] !== $user_id) {
        sendJsonResponse('error', 'Unauthorized to delete this comment.');
    }
    $check_stmt->close();

    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        sendJsonResponse('success', 'Comment deleted successfully.');
    } else {
        sendJsonResponse('error', 'Failed to delete comment.');
    }
    $stmt->close();
} else {
    sendJsonResponse('error', 'Invalid request method.');
}
$conn->close();
?>
