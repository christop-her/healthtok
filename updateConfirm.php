<?php
include 'dbconnection.php';
$response = [];

$patientEmail = $_POST['patientEmail'];
$email = $_POST['email'];
$A_status = $_POST['A_status'];


// Prepare the SQL statement
$update_profile = $conn->prepare("UPDATE bookings SET A_status = ? WHERE email = ? AND DoctorEmail = ?");

// Execute the SQL statement
if ($update_profile->execute([$A_status, $patientEmail, $email])) {
    // Check if any row was affected
    if ($update_profile->rowCount() > 0) {
        $response["message"] = "updated successfully";
    } else {
        $response["error"] = "Not successful";
    }
} else {
    $response["error"] = "Failed to update profile.";
}

// Output the JSON response
echo json_encode($response);
?>
