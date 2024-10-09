<?php

include "dbconnection.php";

$response = [];

try {
    // SQL query to get documents from the database
    $sql = "SELECT * FROM documents"; // Adjust the table name and columns as needed
    
    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Fetch all results
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        http_response_code(200); // OK
        $response["success"] = true;
        $response["documents"] = $documents;
    } else {
        http_response_code(404); // Not Found
        $response["success"] = false;
        $response["message"] = "No documents found";
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    $response["success"] = false;
    $response["message"] = "Database error";
    $response["error"] = $e->getMessage();
}

echo json_encode($response);

?>