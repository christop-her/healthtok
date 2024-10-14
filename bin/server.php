<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Message;

require dirname(__DIR__) . '/vendor/autoload.php';

// Setup the WebSocket server
$messageWebSocket = new WsServer(new Message());
$messageServer = new IoServer(
    new HttpServer($messageWebSocket),
    8081 // Directly bind to port 8081
);

// Start the server
echo "WebSocket server is running on port 8081\n";
$messageServer->run();
