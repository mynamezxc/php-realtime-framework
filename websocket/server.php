<?php

require __DIR__."../../application/config/config.php";
$config = new config();
require __DIR__."../../application/controllers/$config->remote_file_name";
require __DIR__."../../application/disks/autoload.php";

    use Ratchet\Server\IoServer;
    use Ratchet\Http\HttpServer;
    use Ratchet\WebSocket\WsServer;
    use Realtime\ZXC_remote;
        
    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new ZXC_remote()
            )
        ),
        $config->server_default_port
    );
    $server->run();