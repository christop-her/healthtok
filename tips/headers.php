<?php
// Allow CORS for all origins (you can restrict this as needed)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Set content type to JSON for API responses
header("Content-Type: application/json; charset=UTF-8");

// Handle preflight requests (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No Content response
    exit();
}
?>
