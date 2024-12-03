<?php

include "dbconnection.php";

$email = $_POST['email'];
$response = [];

$select_user = $conn->prepare("SELECT * FROM pricing WHERE email = ?");
$select_user->execute([$email]);

if($select_user->rowCount() > 0){
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
    $response["data"][] = $fetch_user;
    $response["message"] = "login successful";
}

echo json_encode($response);