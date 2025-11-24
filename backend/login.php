<?php
header('Content-Type: application/json');

require __DIR__ . '/db.php';
require __DIR__ . '/redis.php';

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password_hash'])) {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid credentials']);
        exit;
    }

    $userId = $user['id'];
    $token  = bin2hex(random_bytes(24));

    $redis->setex("session:{$token}", 24*3600, $userId);

    echo json_encode(['token' => $token, 'message'=>'Login successful']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['message'=>'Server error', 'error'=>$e->getMessage()]);
}
