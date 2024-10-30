<?php
include "dbconnection.php";

$email = $_POST['email'];

$response = [];
$seenList = [];

// Fetch the list of seen messages
$seen = $conn->prepare("SELECT * FROM messageseen WHERE doctoremail = ?");
$seen->execute([$email]);

if($seen->rowCount() > 0){
    while($fetch_list = $seen->fetch(PDO::FETCH_ASSOC)){
        $seenList[] = $fetch_list["messageid"];
    }
}

// Build the query
if (!empty($seenList)) {
    // If $seenList is not empty, add the NOT IN clause
    $seenListPlaceholder = implode(',', array_fill(0, count($seenList), '?'));
    $select_data_query = "SELECT * FROM chats WHERE email = ? AND id NOT IN ($seenListPlaceholder)";
    $params = array_merge([$email], $seenList);
} else {
    // If $seenList is empty, don't add the NOT IN clause
    $select_data_query = "SELECT * FROM chats WHERE email = ?";
    $params = [$email];
}

// Execute the query
$select_data = $conn->prepare($select_data_query);
$select_data->execute($params);

// Fetch the results
if($select_data->rowCount() > 0){
    while($fetch_data = $select_data->fetch(PDO::FETCH_ASSOC)){
        $response[] = $fetch_data;
    }
}

// Return the results as JSON
echo json_encode($response);

?>
