<?php
include "dbconnection.php";

    $injectable = $_POST['injectable'];
    $oral = $_POST['oral'];
    $email = $_POST['email'];


    $response = [];
    
    $select_data = $conn->prepare("SELECT * FROM prescription WHERE injectable = ? AND oral = ? AND email = ?");
    $select_data->execute([$injectable, $oral, $email]);

    if($select_data->rowCount() == 0){

        $insert_data = $conn->prepare("INSERT INTO prescription(injectable, oral, email) VALUES(?,?,?)");
        $insert_data->execute([$injectable, $oral, $email]);
    
        $response["message"] = "successful";
}

echo json_encode($response);