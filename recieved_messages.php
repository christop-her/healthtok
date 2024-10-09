<?php

include "dbconnection.php";

if(isset($_POST['DoctorEmail'])){
    $DoctorEmail = $_POST['DoctorEmail'];

    $response = [];

    $select_data = $conn->prepare("SELECT * FROM chats WHERE DoctorEmail = ? OR email = ?");
    $select_data->execute([$DoctorEmail, $DoctorEmail]);
    
    if($select_data->rowCount() > 0){
        while($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)){

            $response[] = $fetch_data;
        }
   
    }
}
echo json_encode($response);


