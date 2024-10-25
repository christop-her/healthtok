<?php
include 'dbconnection.php';
$response = [];

$rate = $_POST['rate'];
$email = $_POST['email'];


$update_profile = $conn->prepare("UPDATE pricing SET rate = ? WHERE email = ?");

if ($update_profile->execute([$rate, $email])) {
    if ($update_profile->rowCount() > 0) {
        $response["message"] = "updated successfully";
    } else {
        $response["error"] = "Not successful";
    }
} else {
    $response["error"] = "Failed to update profile.";
}

echo json_encode($response);
?>
