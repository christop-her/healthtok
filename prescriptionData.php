<?php

include "dbconnection.php";



    
$email = $_POST['email'];
$false = 'false';

$response = [];

$select_user = $conn->prepare("SELECT * FROM prescription WHERE email = ? AND read_status = ?");
$select_user->execute([$email, $false]);

if($select_user->rowCount() > 0){
    while($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)){ 
    $response["data"][] = $fetch_user;
    $response["message"] = "login successful";
    }
}

echo json_encode($response);