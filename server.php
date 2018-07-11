<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
    require 'realtime_controllers/price.php';
use Realtime\Price;
    require 'application/libraries/autoload.php';

    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new Price()
            )
        ),
        8080
    );

    $server->run();