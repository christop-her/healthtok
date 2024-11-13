<?php

include "dbconnection.php";


$email = $_POST['email'];

$response = [];

$select_data = $conn->prepare("SELECT * FROM journal WHERE email = ? ORDER BY id DESC");
$select_data->execute([$email]);

if($select_data->rowCount() > 0){
    while($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)){ 
    $response["data"][] = $fetch_data;
    $response["message"] = "login successful";
    }
}

echo json_encode($response);