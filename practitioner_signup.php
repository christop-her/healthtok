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
    $department = $data['department'];
    $gender = $data['gender'];
    $dateOfBirth = $data['dateOfBirth'];
} elseif (strpos($contentType, 'multipart/form-data') !== false) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $userpassword = $_POST['userpassword'];
    $cpassword = $_POST['cpassword'];
    $userrole = $_POST['userrole'];
    $department = $_POST['department'];
    $gender = $_POST['gender'];
    $dateOfBirth = $_POST['dateOfBirth'];
} else {
    $response['message'] = 'Unsupported content type: ' . $contentType;
    echo json_encode($response);
    exit;
}

$select_user = $conn->prepare("SELECT * FROM practitioner WHERE email = ?");
$select_user->execute([$email]);

if ($select_user->rowCount() > 0) {
    http_response_code(409); 
    $response["message"] = "Email already exists: $email";
    echo json_encode($response);
    exit();
} else {
    if ($userpassword != $cpassword) {
        http_response_code(400); 
        $response["message"] = "Confirm password incorrect";
        echo json_encode($response);
        exit();
    } else {
        try {
            $insert_user = $conn->prepare("INSERT INTO practitioner(username, email, userpassword, userrole, department, gender, dateOfBirth) VALUES(?,?,?,?,?,?,?)");
            $insert_user->execute([$username, $email, $userpassword, $userrole, $department, $gender, $dateOfBirth]);
            http_response_code(201); 
            $response["success"] = "User registered successfully";
        } catch (Exception $e) {
            http_response_code(500);
            $response["message"] = "Failed to register: " . $e->getMessage();
        }
    }
}

echo json_encode($response);

?>
