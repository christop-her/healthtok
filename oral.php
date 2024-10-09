<?php
include "dbconnection.php";

    $oral = $_POST['oral'];
    $email = $_POST['email'];


    $response = [];
    
    $select_data = $conn->prepare("SELECT * FROM orals WHERE oral = ? AND email = ?");
    $select_data->execute([$oral, $email]);

    if($select_data->rowCount() == 0){

        $insert_data = $conn->prepare("INSERT INTO orals(oral, email, created_at) VALUES(?,?,CURRENT_DATE)");
        $insert_data->execute([$oral, $email]);
    
        $response["message"] = "successful";
}

echo json_encode($response);