<?php
include "dbconnection.php";

    $email = $_POST['email'];
    $question = $_POST['question'];


    $response = [];
    
    $select_data = $conn->prepare("SELECT * FROM question_box WHERE question = ? AND email = ?");
    $select_data->execute([$question, $email]);

    if($select_data->rowCount() == 0){

        $insert_data = $conn->prepare("INSERT INTO question_box(question, email, created_at) VALUES(?,?,CURRENT_DATE)");
        $insert_data->execute([$question, $email]);
    
        $response["message"] = "successful";
}

echo json_encode($response);