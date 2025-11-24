<?php
// Make sure to run: composer require mongodb/mongodb
require __DIR__ . '/../vendor/autoload.php';

$MONGO_URI = getenv('MONGO_URI') ?: 'mongodb://127.0.0.1:27017';
$MONGO_DB  = getenv('MONGO_DB')  ?: 'guvi';

try {
    $client = new MongoDB\Client($MONGO_URI);
    $mongo  = $client->selectDatabase($MONGO_DB);
    $profilesCollection = $mongo->profiles;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['message' => 'MongoDB connection failed', 'error'=>$e->getMessage()]);
    exit;
}
