<?php

namespace Realtime;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require '../application/disks/autoload.php';

class ZXC_remote implements MessageComponentInterface {
    protected $clients;
    protected $price;
    protected $defaultOnceClientID = 0;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        foreach ($this->clients as $client) {
            // Send to all clients connected
            $client->send($this->price);
        }
    }

    public function onOpen(ConnectionInterface $socket) {
        // Store the new connection to send messages to later
        $this->clients->attach($socket);
        // Set default price with database when server open
        $this->price = 1;
    }

    public function onMessage(ConnectionInterface $socket, $data) {

        $data = json_decode($data, true);
        if($data['action'] == "update") {
            if($this->defaultOnceClientID != 0 && $this->defaultOnceClientID == $socket->resourceId) {
                // Get data from API and update once
                $jsonData = @file_get_contents("https://bittrex.com/api/v1.1/public/getticker?market=usdt-btc");
                $arrData  = json_decode($jsonData, true);
                if($arrData['success'] == "true") {
                    $this->price = json_encode($arrData['result']);
                }
                //$this->price = "1 BTC = ". number_format($arrData['bpi']['VND']['rate_float']) . " vnđ / " . $arrData['bpi']['USD']['rate_float'] . " usd";

                foreach ($this->clients as $client) {

                    $client->send($this->price);
                    
                    // The sender is not the receiver, send to each client connected
                    // if ($socket !== $client) {}
                }
            } else if($this->defaultOnceClientID == 0) {
                $this->defaultOnceClientID = $socket->resourceId;
            }
        }
    }

    public function onClose(ConnectionInterface $socket) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($socket);
        if($socket->resourceId == $this->defaultOnceClientID) {
            $this->defaultOnceClientID = 0;
        }
    }

    public function onError(ConnectionInterface $socket, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $socket->close();
    }
}