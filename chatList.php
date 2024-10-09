<?php

include "dbconnection.php";

if (isset($_POST['DoctorEmail']) && isset($_POST['email'])) {

    $emails = json_decode($_POST['email'], true); 

    // $response = ["success" => [], "failed" => []];

    $DoctorEmail = $_POST['DoctorEmail'];

    $response = [];

    foreach ($emails as $email) {
        $select_data = $conn->prepare("SELECT * FROM chats WHERE DoctorEmail = ? AND email = ? OR DoctorEmail = ? AND email = ?");
        $select_data->execute([$DoctorEmail, $email, $email, $DoctorEmail]);

        if ($select_data->rowCount() > 0) {
            while ($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)) {
                $response[] = $fetch_data;
            }
        }
    }
}
echo json_encode($response);
?>
