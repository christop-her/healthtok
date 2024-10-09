<?php

include "dbconnection.php";


$response = [];

$select_data = $conn->prepare("SELECT * FROM blogs");
$select_data->execute();

if($select_data->rowCount() > 0){
    while($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)){ 
    $response["data"][] = $fetch_data;
    $response["message"] = "login successful";
    }
}

echo json_encode($response);