<?php

include "dbconnection.php";

$department = $_POST['department'];
$response = [];

$select_data = $conn->prepare("SELECT * FROM  practitioner WHERE department = ?");
$select_data->execute([$department]);

if($select_data->rowCount() > 0){
    while($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)){ 
    $response["data"][] = $fetch_data;
    $response["message"] = "login successful";
    }
}else {
    $response["message"] = "No practitioners found";
}

echo json_encode($response);