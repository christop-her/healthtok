<?php

require '../vendor/autoload.php';
$api_key = 'AIzaSyBBoOoo9BqHpRasT3Fax6S3iJG76r00eUI';

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

// Set response header to allow CORS (if needed for the frontend)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

try {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the input from the frontend
        $input = json_decode(file_get_contents("php://input"), true);

        // Validate the input to ensure 'message' is provided
        if (!isset($input['message']) || empty($input['message'])) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Message is required'
            ]);
            exit;
        }



        // Initialize Gemini client with API key
        $client = new Client($api_key);
        $chat = $client->geminiPro()->startChat();

        // Send the user's message to the Gemini API
        $userMessage = $input['message'];
        $response = $chat->sendMessage(new TextPart($userMessage));

        // Send response back to the frontend
        echo json_encode([
            'status' => 'success',
            'response' => $response->text()
        ]);
    } else {
        // Handle non-POST requests
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid request method'
        ]);
    }
} catch (Exception $e) {
    // Handle exceptions
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

