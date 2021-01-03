<?php

namespace Source\socket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Source\model\MenssagemModel;

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
        //echo "Nova conexão";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $dado = (array) json_decode($msg);
        if (isset($dado['resource'])) {
            if (isset($this->usuarios[$dado['id']])) {
                $this->usuarios[$dado['id']]->send(json_encode(array("sair"=> true)));
            }
            $this->usuarios[$dado['id']] = $from;
            echo ', TAMANHO: '.sizeof($this->usuarios);
        }else{
            //$this->saveMessage($msg);
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

    public function getAllMsg() {

    }

    public function saveMessage($msg) {
        $dado = (array) json_decode($msg);
        $mensagemModel = new MenssagemModel('', $dado['id_user'], $dado['id_destino'], $dado['msg']);
        $mensagemModel->save();
    }
}