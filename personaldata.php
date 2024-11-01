<?php
include 'dbconnection.php';
$response = [];
$email = $_POST['email'];
$newemail = $_POST['newemail'];
$username = $_POST['username'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$dateofbirth = $_POST['dateofbirth'];


// Prepare the SQL statement
$update_profile = $conn->prepare("UPDATE practitioner SET email = ?, username = ?, gender = ?, phone = ?, dateofbirth = ? WHERE email = ?");

// Execute the SQL statement
if ($update_profile->execute([$newemail, $username, $gender, $phone, $dateofbirth, $email])) {
    // Check if any row was affected
    if ($update_profile->rowCount() > 0) {
        $response["success"] = "update successful";
    } else {
        $response["error"] = "No store found with the given email.";
    }
} else {
    $response["error"] = "Failed to update store profile.";
}

// Output the JSON response
echo json_encode($response);
?>
