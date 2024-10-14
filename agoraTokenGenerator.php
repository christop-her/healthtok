<?php
// Include the Agora RTC token builder
require_once 'AgoraToken/RtcTokenBuilder.php'; // Path to the downloaded Agora token SDK

// Agora credentials
$appID = "83f41b73122a4927952756806c04ece3";
$appCertificate = "ba311325787844efa0603c9f3c77120d";
$channelName = $_POST['channel_name'];  // Channel name sent from the client
$uid = 0;  // Set user ID to 0, meaning Agora will assign one
$role = RtcTokenBuilder::ROLE_PUBLISHER;  // Role for broadcaster
$expireTimeInSeconds = 3600;  // Token validity: 1 hour
$currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
$privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

if (!empty($channelName)) {
    // Build the token using the Agora Token SDK
    $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
    
    // Return the token as JSON response
    echo json_encode([
        'token' => $token,
        'channel' => $channelName
    ]);
} else {
    echo json_encode(['error' => 'Channel name is required']);
}
