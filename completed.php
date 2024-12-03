<?php
include "dbconnection.php";

try {
    $DoctorEmail = $_POST['DoctorEmail'];
    $email = $_POST['email'];
    $time = $_POST['time'];
    $day = $_POST['day'];
    $true = 'true';
    $false = 'false';

    // Prepare and execute the update query
    // $update_status = $conn->prepare("UPDATE bookings SET read_status = ? WHERE email = ? AND DoctorEmail = ? AND Atime = ? AND Adate = ? AND read_status = ?");
    // $update_status->execute([$true, $email, $DoctorEmail, $time, $day, $false]);

    $query = "UPDATE bookings SET read_status = 'true' WHERE email = ? AND DoctorEmail = ? AND Atime = ? AND Adate = ? AND read_status = 'false'";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $email, $DoctorEmail, $time, $day);
$stmt->execute();

    // Check if rows were affected
    if ($query->rowCount() > 0) {
        $response["message"] = "Status updated successfully";
    } else {
        $response["message"] = "No records to update.";
    }

    echo json_encode($response);

} catch (PDOException $e) {
    // Return error in JSON format for debugging
    echo json_encode(["error" => $e->getMessage()]);
}
