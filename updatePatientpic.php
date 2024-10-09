<?php
include 'dbconnection.php';
$response = [];

$image_01 = $_FILES['image_01']['name'];
$image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
$image_size_01 = $_FILES['image_01']['size'];
$image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
$image_folder_01 = 'profile_img/'.$image_01;


$email = $_POST['email'];


// Prepare the SQL statement
$update_profile = $conn->prepare("UPDATE patient SET image_01 = ? WHERE email = ?");

// Execute the SQL statement
if ($update_profile->execute([$image_01, $email])) {
    // Check if any row was affected
    if ($update_profile->rowCount() > 0) {
        move_uploaded_file($image_tmp_name_01, $image_folder_01);
        $response["message"] = "update successful";
    } else {
        $response["error"] = "No store found with the given email.";
    }
} else {
    $response["error"] = "Failed to update store profile.";
}

// Output the JSON response
echo json_encode($response);
?>
