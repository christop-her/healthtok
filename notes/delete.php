<?php
require '../dbconnection.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['id'])) {
        $noteID = intval($_GET['id']);
    try {
        $stmt = $conn->prepare("DELETE FROM notes WHERE noteID = :id");
        $stmt->execute(['id' => $noteID]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Note deleted successfully'
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
        'message' => 'Note ID is required'
    ]);
}
}
?>
