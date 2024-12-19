<?php

include "dbconnection.php";



    
$email = $_POST['email'];
$status = $_POST['a_status'];
// $status = 'confirmed';

$response = [];

$select_user = $conn->prepare("SELECT * FROM bookings WHERE email = ? AND a_status = ?");
$select_user->execute([$email, $status]);

if($select_user->rowCount() > 0){
    while($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)){ 
    $response["data"][] = $fetch_user;
    $response["message"] = "login successful";
    }
}

echo json_encode($response);