<?php

include "dbconnection.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Max-Age: 86400");
    exit(0);
}

$response = []; 

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if (strpos($contentType, 'application/json') !== false) {

    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'] ?? '';

} elseif (strpos($contentType, 'multipart/form-data') !== false || strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
    
    $email = $_POST['email'] ?? '';

} else {
    $response['message'] = 'Unsupported content type: ' . $contentType;
    echo json_encode($response);
    exit;
}

if (!empty($email)){



$select_user = $conn->prepare("SELECT * FROM patient WHERE email = ?");
$select_user->execute([$email]);

if($select_user->rowCount() > 0){
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
    $response["data"][] = $fetch_user;
    $response["message"] = "login successful";
}
}
echo json_encode($response);