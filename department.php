<?php

include "dbconnection.php";

$response = [];
$department = $_POST['department'];
$select_user = $conn->prepare("SELECT * FROM practitioner WHERE department = ?");
$select_user->execute([$department]);

if ($select_user->rowCount() > 0) {
    $response["data"] = $select_user->fetchAll(PDO::FETCH_ASSOC);
    $response["message"] = "login successful";
} else {
    $response["message"] = "No practitioners found";
}

echo json_encode($response);
