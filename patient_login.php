<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "dbconnection.php";
require 'vendor/autoload.php'; // Include JWT library

use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

$secret_key = "kzVp5J+8zGSk0yld/X9pljW6vY5jTm8eT4cSwT7T9G4=";
$issuer = "https://healthtok.onrender.com"; 
$audience = "https://healthtok.onrender.com"; 
$issuedAt = time();
$expirationTime = $issuedAt + 3600; 

$response = ["success" => false];

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Max-Age: 86400"); 
    exit(0);
}

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
    // Query the database for the user
    $select_user = $conn->prepare("SELECT * FROM patient WHERE email = ? AND userpassword = ?");
    $select_user->execute([$email, $userpassword]);

    if ($select_user->rowCount() > 0) {
        $user = $select_user->fetch(PDO::FETCH_ASSOC);

        // Generate JWT Token
        $token_payload = array(
            "iss" => $issuer, 
            "aud" => $audience,
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "data" => array(
                "id" => $user['id'],
                "email" => $user['email'],
                "name" => $user['username']
            )
        );

        $jwt = JWT::encode($token_payload, $secret_key, 'HS256');

        $response["success"] = true;
        $response["message"] = "Login successful";
        $response["token"] = $jwt; // Send JWT token to the client
        $response["user"] = [
            "id" => $user['id'],
            "email" => $user['email'],
            "name" => $user['username']
        ];

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
