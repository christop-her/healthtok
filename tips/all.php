<?php
require '../dbconnection.php';
require 'headers.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $sql = "SELECT * FROM health_tips";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $tips = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['status' => 'success', 'data' => $tips], JSON_PRETTY_PRINT);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to retrieve tips: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.'], JSON_PRETTY_PRINT);
}
?>


