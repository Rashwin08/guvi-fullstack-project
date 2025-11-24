<?php
header('Content-Type: application/json');
require __DIR__ . '/db.php';

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        http_response_code(409);
        echo json_encode(['message' => 'Email already exists']);
        exit;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (email, password_hash) VALUES (?, ?)');
    $stmt->execute([$email, $hashed]);

    echo json_encode(['message' => 'Registered successfully']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Server error', 'error'=>$e->getMessage()]);
}
