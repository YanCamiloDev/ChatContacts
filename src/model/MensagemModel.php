<?php
namespace Source\model;

use PDO;
use PDOException;
use Source\config\DbConfig;

class MenssagemModel extends DbConfig {

  private $idMensagem;
  private $idRementente;
  private $idDestinatario;
  private $mensagem;
  private $dataMsg;

  public function __construct($idMensagem=0, $idRementente=0, $idDestinatario=0, $mensagem='', $dataMsg='') {
    $this->idMensagem = $idMensagem;
    $this->idRementente = $idRementente;
    $this->idDestinatario = $idDestinatario;
    $this->mensagem = $mensagem;
    $this->dataMsg = $dataMsg;
  }

  public function save() {
    try {
      $query = $this->db->prepare("INSERT INTO tb_mensagem (id_rementente, id_destinatario, mensagem) VALUES (?, ?, ?)");
      $query->bindValue(1, $this->idRementente);
      $query->bindValue(2, $this->idDestinatario);
      $query->bindValue(3, $this->mensagem);
      $query->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function listAllMensagens($id) {
    try {
      $query = $this->db->prepare("SELECT * from tb_mensagem where id_remetente = ?");
      $query->bindValue(1, $id);
      $query->execute();
      if ($query->rowCount() > 0) {
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);
        return $dados;
      } else {
        return array();
      }
      
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}