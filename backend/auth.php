<?php
// auth.php - token validation helper
require __DIR__ . '/redis.php';

$token = $_SERVER['HTTP_X_SESSION_TOKEN'] ?? null;

if (!$token) {
    http_response_code(401);
    echo json_encode(['message' => 'Missing token']);
    exit;
}

$userId = $redis->get("session:$token");
if (!$userId) {
    http_response_code(401);
    echo json_encode(['message' => 'Invalid or expired token']);
    exit;
}

$userId = (int)$userId;
