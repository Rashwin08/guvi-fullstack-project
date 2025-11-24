<?php
// Using Predis (composer package). Make sure to run: composer require predis/predis
require __DIR__ . '/../vendor/autoload.php';

$REDIS_HOST = getenv('REDIS_HOST') ?: '127.0.0.1';
$REDIS_PORT = getenv('REDIS_PORT') ?: 6379;

try {
    $redis = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => $REDIS_HOST,
        'port'   => $REDIS_PORT,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Redis connection failed', 'error' => $e->getMessage()]);
    exit;
}
