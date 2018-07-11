<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
    require 'application/controllers/price.php';
use Realtime\price;
    require 'application/disks/autoload.php';

    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new price()
            )
        ),
        8080
    );

    $server->run();