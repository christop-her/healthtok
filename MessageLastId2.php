<?php

include "dbconnection.php";

$DoctorEmail = $_POST['DoctorEmail'];
$email = $_POST['email'];
$status = false; 

$response = [];

$select_data = $conn->prepare("SELECT * FROM chats WHERE email = ? AND DoctorEmail = ? AND read_status = ?");
$select_data->execute([$email, $DoctorEmail, $status]);

if($select_data->rowCount() > 0){
    while($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)){ 
    $response[] = $fetch_data;
    $response["message"] = "login successful";
    }
}

echo json_encode($response);