<?php

include "dbconnection.php";

if(isset($_POST['email']) && isset($_POST['DoctorEmail'])){
    $email = $_POST['email'];
    $DoctorEmail = $_POST['DoctorEmail'];

    $response = [];

    $select_data = $conn->prepare("SELECT * FROM chats WHERE email = ? AND DoctorEmail = ? OR  DoctorEmail = ? AND email = ? ORDER BY id DESC");
    $select_data->execute([$email, $DoctorEmail, $email, $DoctorEmail]);
    
    if($select_data->rowCount() > 0){
        while($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)){ 

            $response[] = $fetch_data;
        }
   
    }
}
echo json_encode($response);


