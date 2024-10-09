<?php
require '../dbconnection.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['title'], $data['content'], $data['authorid'])) {
    try {
        $stmt = $conn->prepare("INSERT INTO notes (title, content, authorID) VALUES (:title, :content, :authorID)");
        $stmt->execute([
            'title' => $data['title'],
            'content' => $data['content'],
            'authorID' => $data['authorid']
        ]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Note added successfully'
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'All fields are required'
    ]);
}
?>
