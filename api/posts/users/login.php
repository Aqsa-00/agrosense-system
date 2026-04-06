<?php
session_start();
require_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $email = isset($data->email) ? trim($data->email) : '';
    $password = isset($data->password) ? trim($data->password) : '';

    if (empty($email) || empty($password)) {
        sendJsonResponse('error', 'Please provide email and password.');
    }

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            sendJsonResponse('success', 'Logged in successfully.', [
                'id' => $row['id'],
                'name' => $row['name']
            ]);
        } else {
            sendJsonResponse('error', 'Invalid password.');
        }
    } else {
        sendJsonResponse('error', 'User not found.');
    }
    $stmt->close();
} else {
    // Check if session exists to auto-login
    if (isset($_SESSION['user_id'])) {
        sendJsonResponse('success', 'User is logged in.', [
             'id' => $_SESSION['user_id'],
             'name' => $_SESSION['user_name']
        ]);
    } else {
       sendJsonResponse('error', 'Not logged in.');
    }
}
$conn->close();
?>
