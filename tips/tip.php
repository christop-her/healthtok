<?php
require '../dbconnection.php';
require 'headers.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        try {
            $sql = "SELECT * FROM health_tips WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $tip = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($tip) {
                echo json_encode(['status' => 'success', 'data' => $tip], JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Tip not found.'], JSON_PRETTY_PRINT);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to retrieve the tip: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Missing tip ID.'], JSON_PRETTY_PRINT);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.'], JSON_PRETTY_PRINT);
}
?>