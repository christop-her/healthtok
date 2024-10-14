<?php
$call_id = $_POST['call_id'];

$stmt = $db->prepare("UPDATE calls SET call_end = NOW() WHERE id = ?");
$stmt->execute([$call_id]);

echo json_encode(['status' => 'success']);
?>
