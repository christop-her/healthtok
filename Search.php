<?php

include "dbconnection.php";

header('Content-Type: application/json'); 

$response = [];  

if (isset($_POST['searchWord'])) {
    
    $searchWord = $_POST['searchWord'];    

    
    $select_user = $conn->prepare(" SELECT id, username, Image_01, department, email 
        FROM practitioner 
        WHERE username LIKE ?
        UNION 
        SELECT id, blogtitle AS username, image_01 AS Image_01, blogbody AS department, blogtitle AS email 
        FROM blogs 
        WHERE blogtitle LIKE ?
    ");


    $searchTerm = "%" . $searchWord . "%";
    
    if ($select_user->execute([$searchTerm, $searchTerm])) {
        if ($select_user->rowCount() > 0) {
            while ($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)) { 
                $response["data"][] = $fetch_user;
            }
            $response["message"] = "successful";
        } else {
            $response["message"] = "no results found";
        }
    } else {
        $response["message"] = "error executing query";
    }
}

echo json_encode($response);
?>
