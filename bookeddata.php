<?php

include "dbconnection.php";



    
$email = $_POST['email'];
// $status = $_POST['status'];
$status = 'false';

$response = [];

$select_user = $conn->prepare("SELECT * FROM bookings WHERE email = ? AND cancel_status = ? OR read_status = ?");
$select_user->execute([$email, $status, $status]);

if($select_user->rowCount() > 0){
    while($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)){ 
    $response["data"][] = $fetch_user;
    $response["message"] = "login successful";
    }
}

echo json_encode($response);