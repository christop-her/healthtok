<?php
include "dbconnection.php";

try {
    $DoctorEmail = $_POST['DoctorEmail'];
    $email = $_POST['email'];
    $status = false;

    $response = [];

    // Prepare and execute the query
    $select_data = $conn->prepare("SELECT * FROM chats WHERE email = ? AND DoctorEmail = ? AND read_status = ?");
    $select_data->execute([$email, $DoctorEmail, $status]);

    // Check if rows were returned
    if ($select_data->rowCount() > 0) {
        while ($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)) {
            $response[] = $fetch_data;
        }
        $response["message"] = "login successful";
    } else {
        $response["message"] = "No data found";
    }

    echo json_encode($response);

} catch (PDOException $e) {
    // Return error in JSON format for debugging
    echo json_encode(["error" => $e->getMessage()]);
}
