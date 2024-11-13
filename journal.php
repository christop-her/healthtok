<!-- 
include "dbconnection.php";

    $entry = $_POST['entries'];
    $email = $_POST['email'];


    $response = [];
    
    $select_data = $conn->prepare("SELECT * FROM journal WHERE entries = ? AND email = ?");
    $select_data->execute([$entry, $email]);

    if($select_data->rowCount() == 0){

        $insert_data = $conn->prepare("INSERT INTO journal(entries, email, created_at) VALUES(?,?,CURRENT_DATE)");
        $insert_data->execute([$entry, $email]);
    
        $response["message"] = "successful";
}

echo json_encode($response); -->