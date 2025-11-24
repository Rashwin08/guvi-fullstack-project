<?php
header('Content-Type: application/json');
require __DIR__ . '/redis.php';

$token = $_SERVER['HTTP_X_SESSION_TOKEN'] ?? null;
if ($token) {
    $redis->del("session:$token");
}

echo json_encode(['message' => 'Logged out']);
