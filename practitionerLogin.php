<?php

include "dbconnection.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Max-Age: 86400");
    exit(0);
}

$response = ["success" => false];


function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}


$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if (strpos($contentType, 'application/json') !== false) {
    $data = json_decode(file_get_contents("php://input"), true);

    $email = sanitize_input($data['email'] ?? '');
    $userpassword = sanitize_input($data['userpassword'] ?? '');
    $userrole = sanitize_input($data['userrole'] ?? '');
    
} elseif (strpos($contentType, 'multipart/form-data') !== false || strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
   
    $email = sanitize_input($_POST['email'] ?? '');
    $userpassword = sanitize_input($_POST['userpassword'] ?? '');
    $userrole = sanitize_input($_POST['userrole'] ?? '');
    
} else {
    $response['message'] = 'Unsupported content type: ' . $contentType;
    http_response_code(400);
    echo json_encode($response);
    exit;
}


if (!empty($email) && !empty($userpassword) && !empty($userrole)) {

    $select_user = $conn->prepare("SELECT * FROM practitioner WHERE email = ? AND userpassword = ? AND userrole = ?");
    $select_user->execute([$email, $userpassword, $userrole]);

    if ($select_user->rowCount() > 0) {
        $response["success"] = true;
        $response["message"] = "Login successful";
        http_response_code(200); 
    } else {
        $response["message"] = 'Incorrect username, password, or role!';
        http_response_code(401);
   
    }
} else {
    $response['message'] = 'Email, password, and role are required!';
    http_response_code(400); 
   
}


echo json_encode($response);

?>
