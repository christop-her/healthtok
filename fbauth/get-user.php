<?php
// Database configuration
include '../dbconnection.php';

// Set the content type to JSON
header('Content-Type: application/json');

// Allow requests from any origin (you can restrict this to specific origins if needed)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

// Get the fbid from the query parameters
$fbid = filter_input(INPUT_GET, 'fbid', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$fbid) {
    echo json_encode(['error' => 'fbid parameter is missing or invalid']);
    exit;
}

try {

    // Prepare the SQL statement
    $stmt = $conn->prepare('SELECT email, role, gender, fbid FROM fbauth WHERE fbid = :fbid');

    // Bind the parameter
    $stmt->bindParam(':fbid', $fbid);

    // Execute the statement
    $stmt->execute();

    // Fetch the user details
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Return the user details as JSON
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} catch (PDOException $e) {
    // Return an error response
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>