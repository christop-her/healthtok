<?php
include "dbconnection.php";

try {
    $DoctorEmails = json_decode($_POST['DoctorEmail'], true); // Decoding JSON array of emails
    $email = $_POST['email'];
    // $email = 'wilfredc685@gmail.com';
    $status = 'false';

    $response = [];
    $response["data"] = [];

    // Loop through each doctor email
    foreach ($DoctorEmails as $DoctorEmail) {
        // Prepare and execute the query for each DoctorEmail
        $select_data = $conn->prepare("SELECT * FROM chats WHERE email = ? AND DoctorEmail = ? AND read_status = ?");
        $select_data->execute([$DoctorEmail, $email, $status]);

        // Check if rows were returned
        if ($select_data->rowCount() > 0) {
            while ($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)) {
                $response["data"][] = $fetch_data;
            }
        }
    }

    // Add a message based on whether data was found or not
    $response["message"] = !empty($response["data"]) ? "Data retrieval successful" : "No data found";

    // Return the JSON response
    echo json_encode($response);

} catch (PDOException $e) {
    // Return error in JSON format for debugging
    echo json_encode(["error" => $e->getMessage()]);
}
?>
