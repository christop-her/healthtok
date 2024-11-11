<?php

include "dbconnection.php";

$response = [];
$department = $_POST['department'];
$select_user = $conn->prepare("SELECT * FROM practitioner Where department = ?");
$select_user->execute([$department]);

if($select_user->rowCount() > 0){
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
    $response["data"][] = $fetch_user;
    $response["message"] = "login successful";
}

echo json_encode($response);