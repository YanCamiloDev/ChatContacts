<?php

namespace Source\socket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {

    protected $usuarios;
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->usuarios = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        echo "Nova conexão";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $dado = (array) json_decode($msg);
        if (isset($dado['resource'])) {
            //echo "salvo";
            $this->usuarios[$dado['id']] = $from;
        }else{
            $this->usuarios[$dado['id_destino']]->send($msg);
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}