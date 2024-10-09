<?php

include "dbconnection.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Max-Age: 86400"); 
    exit(0);
}

$response = ["success" => false];

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if (strpos($contentType, 'application/json') !== false) {
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'] ?? '';
    $userpassword = $data['userpassword'] ?? '';
} elseif (strpos($contentType, 'multipart/form-data') !== false || strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
    $email = $_POST['email'] ?? '';
    $userpassword = $_POST['userpassword'] ?? '';
} else {
    $response['message'] = 'Unsupported content type: ' . $contentType;
    http_response_code(400);
    echo json_encode($response);
    exit;
}

if (!empty($email) && !empty($userpassword)) {
    $select_user = $conn->prepare("SELECT * FROM patient WHERE email = ? AND userpassword = ?");
    $select_user->execute([$email, $userpassword]);

    if ($select_user->rowCount() > 0) {
        $response["success"] = true;
        $response["message"] = "login successful";
        http_response_code(200); 
    } else {
        $response["message"] = 'Incorrect username or password!';
        http_response_code(401); 
        
    }
} else {
    $response['message'] = 'Email and password are required!';
    http_response_code(400); 
    
}

echo json_encode($response);

?>