<?php
include "dbconnection.php";

if(isset($_POST['email']) && isset($_POST['DoctorEmail'])){
    $email = $_POST['email'];
    $DoctorEmail = $_POST['DoctorEmail'];

    $response = [];
    $seenId = [];

    // Fetch all seen message IDs
    $select_seen = $conn->prepare("SELECT messageId FROM messageseen WHERE email = ? AND DoctorEmail = ?");
    $select_seen->execute([$DoctorEmail, $email]);
    if($select_seen->rowCount() > 0){
        while($fetch_seen = $select_seen->fetch(PDO::FETCH_ASSOC)){
            $seenId[] = $fetch_seen['messageid'];
        }
    }

    if (count($seenId) > 0) {
        // Generate placeholders for the seen IDs
        $placeholders = implode(',', array_fill(0, count($seenId), '?'));

        // Prepare the SQL query with placeholders
        $query = "SELECT * FROM chats WHERE email = ? AND DoctorEmail = ? AND id NOT IN ($placeholders)";
        $params = array_merge([$DoctorEmail, $email], $seenId);
    } else {
        // If no seen IDs, no need for the NOT IN clause
        $query = "SELECT * FROM chats WHERE email = ? AND DoctorEmail = ?";
        $params = [$DoctorEmail, $email];
    }

    // Fetch all messages excluding seen ones
    $select_data = $conn->prepare($query);
    $select_data->execute($params);
    
    if($select_data->rowCount() > 0){
        while($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)){
            $response[] = $fetch_data;
        }
    }
}
echo json_encode($response);
?>

