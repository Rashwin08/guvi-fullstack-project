<?php
header('Content-Type: application/json');

require __DIR__ . '/auth.php';
require __DIR__ . '/mongo.php';

$profile = $profilesCollection->findOne(['user_id' => $userId]);

if ($profile) {
    $profile['_id'] = (string)$profile['_id'];
    if (isset($profile['updated_at'])) {
        $profile['updated_at'] = $profile['updated_at']->toDateTime()->format(DATE_ISO8601);
    }
}

echo json_encode(['profile' => $profile]);
