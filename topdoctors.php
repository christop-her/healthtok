<?php

include "dbconnection.php";

$response = [];

$select_user = $conn->prepare("SELECT u.*, COALESCE(COUNT(l.id), 0) AS total_likes
    FROM practitioner u
    LEFT JOIN like_box l ON u.email = l.DoctorEmail
    GROUP BY u.email, u.id  
    ORDER BY total_likes DESC;
");

$select_user->execute();

if ($select_user->rowCount() > 0) {
    while ($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)) {
        $response["data"][] = $fetch_user;
        $response["message"] = "login successful";
    }
}

echo json_encode($response);
