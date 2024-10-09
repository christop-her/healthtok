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
   $DoctorEmail = $data['DoctorEmail']; 
   $email =  $data['email'];
   $reason =  $data['reason'];
   $A_status = "unconfirmed";
} elseif (strpos($contentType, 'multipart/form-data') !== false || strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
   $DoctorEmail = $_POST['DoctorEmail'];
   $email = $_POST['email'];
   $reason = $_POST['reason'];
   $A_status = "unconfirmed";
} else {
    $response['message'] = 'Unsupported content type: ' . $contentType;
    echo json_encode($response);
    exit;
}

    
   $select_user = $conn->prepare("SELECT * FROM bookings WHERE email = ? AND DoctorEmail = ? AND reason = ?");
   $select_user->execute([$email, $DoctorEmail, $reason,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
       http_response_code(409);
       $response["message"] = "booked already";
       echo json_encode($response);
       exit();

    }else{
   $insert_user = $conn->prepare("INSERT INTO bookings(DoctorEmail, email, reason, A_status, created_at) VALUES(?,?,?,?,CURRENT_DATE)");
   $insert_user->execute([$DoctorEmail, $email, $reason, $A_status]);
   
   $response["message"] = "booked successfully";
    }
    
    echo json_encode($response);

