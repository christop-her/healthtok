<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\Chat;
use MyApp\Message;
use MyApp\Appointdelete;
use React\EventLoop\Factory;
use React\Socket\Server as ReactServer;

require dirname(__DIR__) . '/vendor/autoload.php';

// Create event loop
$loop = Factory::create();

// Setup the Chat server
$chatWebSocket = new WsServer(new Chat());
$chatServer = new IoServer(
    new HttpServer($chatWebSocket),
    new ReactServer('0.0.0.0:8082', $loop),
    $loop
);

// Setup the Follow server
$messageWebSocket = new WsServer(new Message());
$messageServer = new IoServer(
    new HttpServer($messageWebSocket),
    new ReactServer('0.0.0.0:8081', $loop),
    $loop
);

$AppointdeleteWebSocket = new WsServer(new Appointdelete());
$AppointdeleteServer = new IoServer(
    new HttpServer($AppointdeleteWebSocket),
    new ReactServer('0.0.0.0:8083', $loop),
    $loop
);

echo "WebSocket servers are running\n";
try {
    $loop->run();
} catch (\Exception $e) {
    error_log("WebSocket Error: " . $e->getMessage());
}

