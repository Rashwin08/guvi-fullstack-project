<?php
header('Content-Type: application/json');

require __DIR__ . '/auth.php';
require __DIR__ . '/mongo.php';

$input = json_decode(file_get_contents('php://input'), true);

$doc = [
    'user_id' => $userId,
    'full_name' => $input['full_name'] ?? '',
    'bio' => $input['bio'] ?? '',
    'skills' => $input['skills'] ?? [],
    'updated_at' => new MongoDB\BSON\UTCDateTime()
];

$profilesCollection->updateOne(['user_id' => $userId], ['$set' => $doc], ['upsert' => true]);

echo json_encode(['message' => 'Profile saved']);
