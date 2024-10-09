<?php
require_once '../vendor/autoload.php';

$config = require 'hybridauth_config.php';

// Start session if not already started
session_start();

use Hybridauth\Hybridauth;

// Set the content type to JSON
header('Content-Type: application/json');

// Allow requests from any origin (you can restrict this to specific origins if needed)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Initialize HybridAuth with configuration
$hybridauth = new Hybridauth($config);

try {
    // Check for the OAuth authorization code in the URL
    $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_SPECIAL_CHARS);
    $provider = filter_input(INPUT_GET, 'provider', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($code && $provider === 'Google') {
        // Get the adapter for Google
        $adapter = $hybridauth->getAdapter('Google');
        
        // Authenticate using the authorization code
        $adapter->authenticate();
        
        // Retrieve user profile information from Google
        $userProfile = $adapter->getUserProfile();
        
        // Extract required fields
        $response = [
            'firstName' => $userProfile->firstName,
            'lastName' => $userProfile->lastName,
            'email' => $userProfile->email,
            'photoURL' => $userProfile->photoURL
        ];
        
        // Return user profile data as JSON
        echo json_encode($response);
        
        // Optionally, you can disconnect from the provider after handling the callback
        $adapter->disconnect();
        
    } else {
        throw new \Exception('No authorization code found in callback URL');
    }
    
} catch (\Exception $e) {
    echo json_encode(['error' => 'Oops! Something went wrong during the callback: ' . $e->getMessage()]);
}
?>
