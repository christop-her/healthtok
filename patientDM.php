<?php

include "dbconnection.php";

   $email = $_POST['email'];
   $myMessage = $_POST['mymessage'];
   

   $response = [];
    
   $select_data = $conn->prepare("SELECT * FROM directmessage WHERE email = ? AND mymessage");
   $select_data->execute([$email, $myMessage]);
   $row = $select_data->fetch(PDO::FETCH_ASSOC);

   if($select_data->rowCount() > 0){
       $response["success"] = "message  already sent";
       
    }else{
   $insert_data = $conn->prepare("INSERT INTO directmessage(email, mymessage) VALUES(?,?)");
   $insert_data->execute([$email, $myMessage]);
   
          
        //   move_uploaded_file($image_tmp_name_01, $image_folder_01);
   $response["success"] = "message sent";
       }
    


    echo json_encode($response);

