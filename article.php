<?php
include "dbconnection.php";

$response = [];

$select_user = $conn->prepare("SELECT * FROM blogs");
$select_user->execute();

if ($select_user->rowCount() > 0) {
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
    
    // Encode the image_01 data to base64 if it exists
    if (!empty($fetch_user['image_01'])) {
        $fetch_user['image_01'] = base64_encode($fetch_user['image_01']);
    }
    
    $response["data"][] = $fetch_user;
    $response["message"] = "login successful";
} else {
    $response["message"] = "no data found";
}

echo json_encode($response);
