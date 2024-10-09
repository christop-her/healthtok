<?php

include "dbconnection.php";


   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = 'blog_img/'.$image_01;

   $blogtitle = $_POST['blogtitle'];
   $blogbody = $_POST['blogbody'];
   

   $response = [];
    
//    $select_user = $conn->prepare("SELECT * FROM `blogs`");
//    $select_user->execute([$email,]);
//    $row = $select_user->fetch(PDO::FETCH_ASSOC);

//    if($select_user->rowCount() > 0){
//        $response["success"] = "email is  already registered";
       
//     }else{
   $insert_user = $conn->prepare("INSERT INTO blogs(image_01, blogtitle, blogbody, created_at) VALUES(?,?,?,CURRENT_DATE)");
   $insert_user->execute([$image_01, $blogtitle, $blogbody]);
   
          
          move_uploaded_file($image_tmp_name_01, $image_folder_01);
          $response["success"] = "blog uploaded";
    //    }
    


    echo json_encode($response);

