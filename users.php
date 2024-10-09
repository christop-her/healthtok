<?php

include "dbconnection.php";

$response = [];

try {
    // SQL query to get users from both patient and practitioner tables
    $sql = "
        SELECT 'patient' AS user_type, id, username, email FROM patient
        UNION
        SELECT 'practitioner' AS user_type, id, username, email FROM practitioner
    ";
    
    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Fetch all results
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        // Exclude the password field from each user record
        foreach ($users as &$user) {
            unset($user['userpassword']);
        }

        http_response_code(200); // OK
        $response["success"] = true;
        $response["users"] = $users;
    } else {
        http_response_code(404); // Not Found
        $response["success"] = false;
        $response["message"] = "No users found";
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    $response["success"] = false;
    $response["message"] = "Database error";
    $response["error"] = $e->getMessage();
}

echo json_encode($response);

?>