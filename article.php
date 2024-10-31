<?php

include "dbconnection.php";

$response = [];

$select_user = $conn->prepare("SELECT * FROM blogs");
$select_user->execute();

if($select_user->rowCount() > 0){
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
    $response["data"][] = $fetch_user;
    $response["message"] = "login successful";
}

echo json_encode($response);