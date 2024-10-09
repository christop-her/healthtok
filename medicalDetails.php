<?php

include "dbconnection.php";

   $allegies = $_POST['allegies'];
   $surgical_history = $_POST['surgical_history'];
   $bloodGroup = $_POST['bloodGroup'];
   $Fmedical_history = $_POST['Fmedical_history'];
   $gender = $_POST['gender'];
   $email = $_POST['email'];
   $genotype = $_POST['genotype'];
   $dateOfBirth = $_POST['dateOfBirth'];
   $disability = $_POST['disability'];   
   $smoker = $_POST['smoker'];

   $response = [];

   $select_user = $conn->prepare("SELECT * FROM MedicalDetails WHERE allegies = ? AND surgical_history = ? AND bloodGroup = ? AND Fmedical_history = ? AND gender = ? AND email = ? AND genotype = ? AND dateOfBirth = ? AND disability = ? AND smoker = ?");
   $select_user->execute([$allegies, $surgical_history, $bloodGroup, $Fmedical_history, $gender, $email, $genotype, $dateOfBirth, $disability, $smoker]);

   if($select_user->rowCount() > 0){
       $response["message"] = "already registered";
       
    }else{
   $insert_user = $conn->prepare("INSERT INTO MedicalDetails(allegies, surgical_history, bloodGroup, Fmedical_history, gender, email, genotype, dateOfBirth, disability, smoker, created_at) VALUES(?,?,?,?,?,?,?,?,?,?,CURRENT_DATE)");
   $insert_user->execute([$allegies, $surgical_history, $bloodGroup, $Fmedical_history, $gender, $email, $genotype, $dateOfBirth, $disability, $smoker]);
   
          $response["message"] = "submitted";
   }


    echo json_encode($response);

