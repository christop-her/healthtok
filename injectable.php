<?php
include "dbconnection.php";

    $injectable = $_POST['injectable'];
    $email = $_POST['email'];


    $response = [];
    
    $select_data = $conn->prepare("SELECT * FROM injectables WHERE injectable = ? AND email = ?");
    $select_data->execute([$injectable, $email]);

    if($select_data->rowCount() == 0){

        $insert_data = $conn->prepare("INSERT INTO injectables(injectable, email, created_at) VALUES(?,?,CURRENT_DATE)");
        $insert_data->execute([$injectable, $email]);
    
        $response["message"] = "successful";
}

echo json_encode($response);