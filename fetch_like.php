<?php
include "dbconnection.php";

$email = $_POST['email'];
$DoctorEmail = $_POST['DoctorEmail'];

    $response = [];
    
    $select_user = $conn->prepare("SELECT * FROM like_box WHERE DoctorEmail = ? AND email = ?");
    $select_user->execute([$DoctorEmail, $email]);

    if($select_user->rowCount() > 0){
    
        $response["message"] = "like successful";
}

echo json_encode($response);