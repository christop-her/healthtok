<?php

include "dbconnection.php";


   $degree_image = $_FILES['degree_image']['name'];
   $degree_image = filter_var($degree_image, FILTER_SANITIZE_STRING);
   $degree_image_size_01 = $_FILES['degree_image']['size'];
   $degree_image_tmp_name_01 = $_FILES['degree_image']['tmp_name'];
   $degree_image_folder_01 = 'donation_img/'.$degree_image;

   $specialty_image = $_FILES['specialty_image']['name'];
   $specialty_image = filter_var($specialty_image, FILTER_SANITIZE_STRING);
   $specialty_image_size_01 = $_FILES['specialty_image']['size'];
   $specialty_image_tmp_name_01 = $_FILES['specialty_image']['tmp_name'];
   $specialty_image_folder_01 = 'donation_img/'.$specialty_image;

   $certification_image = $_FILES['certification_image']['name'];
   $certification_image = filter_var($certification_image, FILTER_SANITIZE_STRING);
   $certification_image_size_01 = $_FILES['certification_image']['size'];
   $certification_image_tmp_name_01 = $_FILES['certification_image']['tmp_name'];
   $certification_image_folder_01 = 'donation_img/'.$certification_image;

   $cv_image = $_FILES['cv_image']['name'];
   $cv_image = filter_var($cv_image, FILTER_SANITIZE_STRING);
   $cv_image_size_01 = $_FILES['cv_image']['size'];
   $cv_image_tmp_name_01 = $_FILES['cv_image']['tmp_name'];
   $cv_image_folder_01 = 'donation_img/'.$cv_image;

   $issuedid_image = $_FILES['issuedid_image']['name'];
   $issuedid_image = filter_var($issuedid_image, FILTER_SANITIZE_STRING);
   $issuedid_image_size_01 = $_FILES['issuedid_image']['size'];
   $issuedid_image_tmp_name_01 = $_FILES['issuedid_image']['tmp_name'];
   $issuedid_image_folder_01 = 'donation_img/'.$issuedid_image;

   $proficiency = $_POST['proficiency'];
   $olanguage = $_POST['olanguage'];
   

   $response = [];

   $select_data = $conn->prepare("SELECT * FROM credentials WHERE degree_image = ? AND specialty_image = ? AND certification_image = ? AND cv_image = ? AND issuedid_image = ? AND proficiency = ? AND olanguage = ?");
   $select_data->execute([$degree_image, $specialty_image, $certification_image, $cv_image, $issuedid_image, $proficiency, $olanguage]);

   if($select_data->rowCount() > 0){
       $response["message"] = "already registered";
       
    }else{
   $insert_user = $conn->prepare("INSERT INTO credentials(degree_image, specialty_image, certification_image, cv_image, issuedid_image, proficiency, olanguage, created_at) VALUES(?,?,?,?,?,?,?,CURRENT_DATE)");
   $insert_user->execute([$degree_image, $specialty_image, $certification_image, $cv_image, $issuedid_image, $proficiency, $olanguage]);
   
          
          move_uploaded_file($degree_image_tmp_name_01, $degree_image_folder_01);
          move_uploaded_file($specialty_image_tmp_name_01, $specialty_image_folder_01);
          move_uploaded_file($certification_image_tmp_name_01, $certification_image_folder_01);
          move_uploaded_file($cv_image_tmp_name_01, $cv_image_folder_01);
          move_uploaded_file($issuedid_image_tmp_name_01, $issuedid_image_folder_01);
          $response["message"] = "submitted";
       }


    echo json_encode($response);

