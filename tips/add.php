<?php
require '../dbconnection.php';
require 'headers.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['tip']) && isset($data['authorID'])) {
        $tip = $data['tip'];
        $authorID = intval($data['authorID']);

        try {
            $sql = "INSERT INTO health_tips (tip, authorID) VALUES (:tip, :authorID)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':tip', $tip);
            $stmt->bindParam(':authorID', $authorID);

            if ($stmt->execute()) {
                http_response_code(201); // Tip added successfully
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Tip added successfully.',
                    'data' => [
                        'id' => $conn->lastInsertId(),
                        'tip' => $tip,
                        'authorID' => $authorID,
                    ]
                ]);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to add the tip.']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields: tip, authorID.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
}
?>