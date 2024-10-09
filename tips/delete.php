<?php
require '../dbconnection.php';
require 'headers.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        try {
            $sql = "DELETE FROM health_tips WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    http_response_code(200); // Successfully deleted
                    echo json_encode(['status' => 'success', 'message' => 'Tip deleted successfully.']);
                } else {
                    http_response_code(404); // Tip not found
                    echo json_encode(['status' => 'error', 'message' => 'Tip not found.']);
                }
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete the tip.']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Missing tip ID.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
}
?>