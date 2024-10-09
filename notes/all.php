<?php
require '../dbconnection.php';  // Including database connection

header("Content-Type: application/json");

try {
    $stmt = $conn->query("SELECT * FROM notes ORDER BY created_at DESC");
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode([
        'status' => 'success',
        'data' => $notes
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
