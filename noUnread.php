<?php
include "dbconnection.php";

$email = $_POST['email'];

$response = [];
$seenList = [];

// Fetch the list of seen messages
$seen = $conn->prepare("SELECT * FROM messageseen WHERE email = ?");
$seen->execute([$email]);

if($seen->rowCount() > 0){
    while($fetch_list = $seen->fetch(PDO::FETCH_ASSOC)){
        $seenList[] = $fetch_list["messageid"];
    }
}


if (!empty($seenList)) {
  
    $seenListPlaceholder = implode(',', array_fill(0, count($seenList), '?'));
    $select_data_query = "SELECT * FROM chats WHERE doctoremail = ? AND id NOT IN ($seenListPlaceholder)";
    $params = array_merge([$email], $seenList);
} else {
    
    $select_data_query = "SELECT * FROM chats WHERE doctoremail = ?";
    $params = [$email];
}


$select_data = $conn->prepare($select_data_query);
$select_data->execute($params);


if($select_data->rowCount() > 0){
    while($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)){
        $response[] = $fetch_data;
    }
}


echo json_encode($response);

?>
