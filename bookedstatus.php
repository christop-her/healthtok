<?php

include "dbconnection.php";



$patientEmail = $_POST['patientEmail'];
$email = $_POST['email'];

$response = [];

$select_user = $conn->prepare("SELECT * FROM bookings WHERE email = ? AND DoctorEmail = ?");
$select_user->execute([$patientEmail, $email]);

if($select_user->rowCount() > 0){
    while($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)){ 
    $response["data"][] = $fetch_user;
    $response["message"] = "login successful";
    }
}

echo json_encode($response);