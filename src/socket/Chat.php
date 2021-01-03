<?php

namespace Source\socket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Source\model\MensagemModel;
use Source\model\MenssagemModel;

class Chat implements MessageComponentInterface {

    protected $usuarios;
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        foreach ($this->getAllIds() as $id){
            $this->usuarios[$id['id_user']] = null;
        }
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        try {
            $dado = (array) json_decode($msg);
            if (isset($dado['resource'])) {
                if (isset($this->usuarios[$dado['id']])) {
                    $this->usuarios[$dado['id']]->send(json_encode(array("sair"=> true)));
                }
                $this->usuarios[$dado['id']] = $from;
                echo ', TAMANHO: '.sizeof($this->usuarios);
            }else{
                $this->saveMessage($msg);
                if(isset($this->usuarios[$dado['id_destino']])){
                    $this->usuarios[$dado['id_destino']]->send($msg);
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
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

    public function getAllIds() {
        $ms = new MensagemModel();
        $ids = $ms->listUser();
        return (array) $ids;
    }

    public function saveMessage($msg) {
        $data = (array) json_decode($msg);
        $usuario = new MensagemModel('', $data['id_user'], $data['id_destino'], $data['msg'], '');
        $re = $usuario->save();
        echo json_encode(array("response" => $re));
    }
}