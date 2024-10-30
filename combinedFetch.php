<?php
include "dbconnection.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $DoctorEmail = $_POST['DoctorEmail'] ?? '';
    $email = $_POST['email'] ?? '';

    $response = [
        "received_messages" => [],
        "chat_list" => [],
        "patient_data" => null
    ];

    // 1. Fetch Received Messages
    $select_data = $conn->prepare("SELECT * FROM chats WHERE DoctorEmail = ? OR email = ?");
    $select_data->execute([$DoctorEmail, $DoctorEmail]);
    while ($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)) {
        $response["received_messages"][] = $fetch_data;
    }

    // 2. Fetch Chat List
    $emails = json_decode($email, true); // Decode JSON array of emails
    foreach ($emails as $chatEmail) {
        $select_data = $conn->prepare("SELECT * FROM chats WHERE (DoctorEmail = ? AND email = ?) OR (DoctorEmail = ? AND email = ?)");
        $select_data->execute([$DoctorEmail, $chatEmail, $chatEmail, $DoctorEmail]);
        while ($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)) {
            $response["chat_list"][] = $fetch_data;
        }
    }

    // 3. Fetch Patient Data
    if (!empty($DoctorEmail)) {
        $select_user = $conn->prepare("SELECT * FROM patient WHERE email = ?");
        $select_user->execute([$DoctorEmail]);
        if ($select_user->rowCount() > 0) {
            $response["patient_data"] = $select_user->fetch(PDO::FETCH_ASSOC);
        }
    }

    echo json_encode($response);
}
?>
