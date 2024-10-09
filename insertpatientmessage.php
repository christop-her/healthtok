<?php

include "dbconnection.php";
//    $image_01 = $_FILES['image_01']['name'];
//    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
//    $image_size_01 = $_FILES['image_01']['size'];
//    $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
//    $image_folder_01 = 'blog_img/'.$image_01;

   $DoctorEmail = $_POST['DoctorEmail'];
   $email = $_POST['email'];
   $myMessage = $_POST['myMessage'];
   

   $response = [];
    
//    $select_data = $conn->prepare("SELECT * FROM `chats`");
//    $select_data->execute([$email,]);
//    $row = $select_data->fetch(PDO::FETCH_ASSOC);

//    if($select_data->rowCount() > 0){
//        $response["success"] = "email is  already registered";
       
//     }else{
   $insert_data = $conn->prepare("INSERT INTO chats(DoctorEmail, email, myMessage) VALUES(?,?,?)");
   $insert_data->execute([$DoctorEmail, $email, $myMessage]);
   
          
        //   move_uploaded_file($image_tmp_name_01, $image_folder_01);
   $response["success"] = "message sent";
    //    }
    


    echo json_encode($response);

