<?php

include "dbconnection.php";


   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = 'donation_img/'.$image_01;

   $username = $_POST['username'];
   $user_address = $_POST['user_address'];
   $phone = $_POST['phone'];
   $gender = $_POST['gender'];
   $userrole = $_POST['userrole'];
   $email = $_POST['email'];
   $rhesusfactor = $_POST['rhesusfactor'];
   $dateOfDelivery = $_POST['dateOfDelivery'];
   

   $response = [];
   
   if($userrole == 'Donor'){


   $select_user = $conn->prepare("SELECT * FROM BloodDonor WHERE image_01 = ? AND username = ? AND user_address = ? AND phone = ? AND gender = ? AND userrole = ? AND email = ?");
   $select_user->execute([$image_01, $username, $user_address, $phone, $gender, $userrole, $email]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
       $response["success"] = "already registered";
       
    }else{
   $insert_user = $conn->prepare("INSERT INTO BloodDonor(image_01, username, user_address, phone, gender, userrole, email) VALUES(?,?,?,?,?,?,?)");
   $insert_user->execute([$image_01, $username, $user_address, $phone, $gender, $userrole, $email]);
   
          
          move_uploaded_file($image_tmp_name_01, $image_folder_01);
          $response["success"] = "submitted";
       }


   } 
   
   
   elseif ($userrole == 'Recipient') {
    
    $select_user = $conn->prepare("SELECT * FROM BloodRecipient WHERE username = ? AND user_address = ? AND phone = ? AND gender = ? AND userrole = ? AND email = ?");
   $select_user->execute([$username, $user_address, $phone, $gender, $userrole, $email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
 
    if($select_user->rowCount() > 0){
        $response["success"] = "already registered";
        
     }else{
    $insert_user = $conn->prepare("INSERT INTO BloodRecipient(username, user_address, phone, gender, dateOfDelivery, rhesusfactor, userrole, email) VALUES(?,?,?,?,?,?,?,?)");
    $insert_user->execute([$username, $user_address, $phone, $gender, $dateOfDelivery, $rhesusfactor, $userrole, $email]);
    
           
         //   move_uploaded_file($image_tmp_name_01, $image_folder_01);
           $response["success"] = "submitted";
        }
   }


    echo json_encode($response);

