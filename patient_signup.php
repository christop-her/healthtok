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
    $username = $data['username'];
    $email = $data['email'];
    $userpassword = $data['userpassword'];
    $cpassword = $data['cpassword'];
    $userrole = $data['userrole'];
} elseif (strpos($contentType, 'multipart/form-data') !== false || strpos($contentType, 'application/x-www-form-urlencoded') !== false) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $userpassword = $_POST['userpassword'];
    $cpassword = $_POST['cpassword'];
    $userrole = $_POST['userrole'];
} else {
   
    http_response_code(415); // 415 Unsupported Media Type
    $response['message'] = 'Unsupported content type: ' . $contentType;
    echo json_encode($response);
    exit();
}

$select_user = $conn->prepare("SELECT * FROM patient WHERE email = ?");
$select_user->execute([$email]);

if ($select_user->rowCount() > 0) {
    http_response_code(409); // 409 Conflict
    $response["message"] = "Email already exists: $email";
    echo json_encode($response);
    exit();
} else {
    if ($userpassword != $cpassword) {
        http_response_code(400); // 400 Bad Request
        $response["message"] = "Confirm password incorrect";
        echo json_encode($response);
        exit();
    } else {
        try {
            $insert_user = $conn->prepare("INSERT INTO patient(username, email, userpassword, userrole) VALUES(?,?,?,?)");
            $insert_user->execute([$username, $email, $userpassword, $userrole]);
            http_response_code(201); // 201 Created
            $response["success"] = "User registered successfully";
        } catch (Exception $e) {
            http_response_code(500); // 500 Internal Server Error
            $response["message"] = "Error occurred: " . $e->getMessage();
            echo json_encode($response);
            exit();
        }
    }
}

echo json_encode($response);

?>
