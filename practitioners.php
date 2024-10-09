<?php

include "dbconnection.php";

$response = [];

try {
    // Fetch all practitioners
    $select_practitioners = $conn->prepare("SELECT * FROM practitioner");
    $select_practitioners->execute();
    $practitioners = $select_practitioners->fetchAll(PDO::FETCH_ASSOC);

    if ($select_practitioners->rowCount() > 0) {
        // Exclude the password field from each practitioner record
        foreach ($practitioners as &$practitioner) {
            unset($practitioner['userpassword']);
        }

        http_response_code(200); // OK
        $response["success"] = true;
        $response["practitioners"] = $practitioners;
    } else {
        http_response_code(404); // Not Found
        $response["success"] = false;
        $response["message"] = "No practitioners found";
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    $response["success"] = false;
    $response["message"] = "Database error";
    $response["error"] = $e->getMessage();
}

echo json_encode($response);

?>