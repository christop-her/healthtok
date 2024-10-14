<?php

include "dbconnection.php";

$patient_id = $_POST['patient_id'];
$practitioner_id = $_POST['practitioner_id'];
$channel_name = 'channel_' . uniqid();  // Generate unique channel name

// Insert call data into the database
$stmt = $db->prepare("INSERT INTO calls (patient_id, practitioner_id, channel_name) VALUES (?, ?, ?)");
$stmt->execute([$patient_id, $practitioner_id, $channel_name]);

// Fetch Agora token (from the script above)
$tokenResponse = file_get_contents('https://healthtok.onrender.com/agoraTokenGenerator.php?channel=' . $channel_name);
$tokenData = json_decode($tokenResponse, true);

// Return token and channel to the Flutter app
echo json_encode([
    'token' => $tokenData['token'],
    'channel' => $channel_name
]);
?>
