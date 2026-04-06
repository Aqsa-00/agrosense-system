<?php
require_once '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $name = isset($data->name) ? trim($data->name) : '';
    $email = isset($data->email) ? trim($data->email) : '';
    $password = isset($data->password) ? trim($data->password) : '';

    if (empty($name) || empty($email) || empty($password)) {
        sendJsonResponse('error', 'Please fill all required fields.');
    }

    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    if ($check_stmt->num_rows > 0) {
        $check_stmt->close();
        sendJsonResponse('error', 'Email already exists.');
    }
    $check_stmt->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        sendJsonResponse('success', 'User registered successfully.');
    } else {
        sendJsonResponse('error', 'Registration failed.');
    }
    $stmt->close();
} else {
     sendJsonResponse('error', 'Invalid request method.');
}
$conn->close();
?>
