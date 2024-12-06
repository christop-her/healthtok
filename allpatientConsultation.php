<?php

include "dbconnection.php";

if(isset($_POST['email'])){
    $email = $_POST['email'];
    

    $response = [];

    $select_data = $conn->prepare("SELECT * FROM consultation WHERE email = ? ORDER BY id ASC");
    $select_data->execute([$email]);
    
    if($select_data->rowCount() > 0){
        while($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)){ 

            $response[] = $fetch_data;
        }
   
    }
}
echo json_encode($response);


