<?php

include "dbconnection.php";

$response = [];

try {
    // Fetch all patients
    $select_patients = $conn->prepare("SELECT * FROM patient");
    $select_patients->execute();
    $patients = $select_patients->fetchAll(PDO::FETCH_ASSOC);

    if ($select_patients->rowCount() > 0) {
        // Exclude the password field from each patient record
        foreach ($patients as &$patient) {
            unset($patient['userpassword']);
        }

        http_response_code(200); // OK
        $response["success"] = true;
        $response["patients"] = $patients;
    } else {
        http_response_code(404); // Not Found
        $response["success"] = false;
        $response["message"] = "No patients found";
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    $response["success"] = false;
    $response["message"] = "Database error";
    $response["error"] = $e->getMessage();
}

echo json_encode($response);

?>