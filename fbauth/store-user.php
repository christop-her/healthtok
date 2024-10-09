<?php
// Database configuration
include '../dbconnection.php';

// Set the content type to JSON
header('Content-Type: application/json');

// Allow requests from any origin (you can restrict this to specific origins if needed)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	echo json_encode(['error' => 'Invalid request method']);
	exit;
}

// Get the input data
$input = json_decode(file_get_contents('php://input'), true);

// Validate and sanitize input data
$email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
$role = filter_var($input['role'], FILTER_SANITIZE_SPECIAL_CHARS);
$gender = filter_var($input['gender'], FILTER_SANITIZE_SPECIAL_CHARS);
$fbid = filter_var($input['fbid'], FILTER_SANITIZE_SPECIAL_CHARS);

if (!$email || !$role || !$gender || !$fbid) {
	echo json_encode(['error' => 'Invalid input data']);
	exit;
}

try {

	// Prepare the SQL statement
	$stmt = $conn->prepare('INSERT INTO fbauth (email, role, gender, fbid) VALUES (:email, :role, :gender, :fbid)');

	// Bind the parameters
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':role', $role);
	$stmt->bindParam(':gender', $gender);
	$stmt->bindParam(':fbid', $fbid);

	// Execute the statement
	$stmt->execute();

	// Return a success response
	echo json_encode(['success' => 'User details stored successfully']);
} catch (PDOException $e) {
	// Return an error response
	echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>