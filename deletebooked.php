<?php
include "dbconnection.php";


    $email = $_POST['email'];
    $DoctorEmail = $_POST['DoctorEmail'];

    $response = [];
    
    $select_user = $conn->prepare("SELECT * FROM bookings WHERE email = ? AND DoctorEmail = ?");
    $select_user->execute([$email, $DoctorEmail]);

    if($select_user->rowCount() > 0){

        $delete_user = $conn->prepare("DELETE FROM bookings WHERE email = ? AND DoctorEmail = ?");
        $delete_user->execute([$email, $DoctorEmail]);
        $response["message"] = "deleted successful";
    }

echo json_encode($response);