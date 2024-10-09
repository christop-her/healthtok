<?php

require './vendor/autoload.php';
$api_key = 'AIzaSyBBoOoo9BqHpRasT3Fax6S3iJG76r00eUI';

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

// Initialize Gemini client with API key
$client = new Client($api_key);
$chat = $client->geminiPro()->startChat();

echo "Welcome to Gemini Chat! Type your message and press Enter. Type 'exit' to quit.\n";

while (true) {
    // Get user input from the terminal
    $userInput = readline("You: ");

    // Exit the loop if the user types 'exit'
    if (strtolower($userInput) === 'exit') {
        echo "Exiting chat...\n";
        break;
    }

    // Send the user input as a message to the chat
    $response = $chat->sendMessage(new TextPart($userInput));

    // Print the response from Gemini
    echo "Gemini: " . $response->text() . "\n";
}

?>