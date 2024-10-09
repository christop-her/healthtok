<?php
require_once '../vendor/autoload.php';

$config = require 'hybridauth_config.php';

use Hybridauth\Hybridauth;

// Set the content type to JSON
header('Content-Type: application/json');

// Allow requests from any origin (you can restrict this to specific origins if needed)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Validate and sanitize the provider parameter
$provider = filter_input(INPUT_GET, 'provider', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$provider) {
    echo json_encode(['error' => 'Provider parameter is missing or invalid']);
    exit;
}

try {
    // Initialize HybridAuth with the config
    $hybridauth = new Hybridauth($config);

    // Authenticate the user using the selected provider
    $adapter = $hybridauth->authenticate($provider);

    // Redirect the user to authorization page
    $adapter->redirect();
} catch (\Exception $e) {
    echo json_encode(['error' => 'Oops! Something went wrong: ' . $e->getMessage()]);
}
