<?php
require '../dbconnection.php';

header("Content-Type: application/json");

if (isset($_GET['id'])) {
    $noteID = $_GET['id'];
    try {
        $stmt = $conn->prepare("SELECT * FROM notes WHERE noteID = :id");
        $stmt->execute(['id' => $noteID]);
        $note = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($note) {
            echo json_encode([
                'status' => 'success',
                'data' => $note
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'status' => 'error',
                'message' => 'Note not found'
            ]);
        }
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
        'message' => 'Note ID is required'
    ]);
}
?>
