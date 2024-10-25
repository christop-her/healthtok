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
    $fullname = $data['fullname'];
    $dob = $data['dob'];
    $gender = $data['gender'];
    $phone = $data['phone'];
    $email = $data['email'];
} elseif (strpos($contentType, 'multipart/form-data') !== false) {
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
} else {
    $response['message'] = 'Unsupported content type: ' . $contentType;
    echo json_encode($response);
    exit;
}

$select_user = $conn->prepare("SELECT * FROM personal_data WHERE email = ? AND fullname = ? AND dob = ? AND gender = ? AND phone = ?");
$select_user->execute([$email, $fullname, $dob, $gender, $phone]);

if ($select_user->rowCount() > 0) {
    http_response_code(409); 
    $response["message"] = "data already exists: $email";
    echo json_encode($response);
    exit();
} else {
        try {
            $insert_user = $conn->prepare("INSERT INTO personal_data(email, fullname, dob, gender, phone) VALUES(?,?,?,?,?)");
            $insert_user->execute([$email, $fullname, $dob, $gender, $phone]);
            http_response_code(201); 
            $response["success"] = "registered successfully";
        } catch (Exception $e) {
            http_response_code(500);
            $response["message"] = "Failed to register: " . $e->getMessage();
        }
    }


echo json_encode($response);

?>
