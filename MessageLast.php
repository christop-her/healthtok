<?php
include "dbconnection.php";

try {
    $DoctorEmail = $_POST['DoctorEmail'];
    $email = $_POST['email'];
    $true = 'true';
    $false = 'false';

    // Prepare and execute the update query
    $update_status = $conn->prepare("UPDATE chats SET read_status = ? WHERE email = ? AND DoctorEmail = ? AND read_status = ?");
    $update_status->execute([$true, $email, $DoctorEmail, $false]);

    // Check if rows were affected
    if ($update_status->rowCount() > 0) {
        $response["message"] = "Status updated successfully for " . $update_status->rowCount() . " records.";
    } else {
        $response["message"] = "No records to update.";
    }

    echo json_encode($response);

} catch (PDOException $e) {
    // Return error in JSON format for debugging
    echo json_encode(["error" => $e->getMessage()]);
}
