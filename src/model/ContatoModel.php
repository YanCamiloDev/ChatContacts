<?php

namespace Source\model;

use PDO;
use PDOException;
use Source\config\DbConfig;

class ContatoModel extends DbConfig {

  public $idContato;
  public $nome;
  public $telefone;
  public $idUsuario;

  public function __construct($nome="", $telefone="") {
    parent::__construct();
    $this->idContato = "";
    $this->nome = $nome;
    $this->telefone = $telefone;
    $this->idUsuario = "";
  }

  public function saveContact($idUser) {
    try {
      $this->db->beginTransaction();
      $this->idUsuario = $idUser;
      $query = $this->db->prepare("INSERT INTO tb_contato (nome, telefone) 
      VALUES (?, ?) returning id_contato");
      $query->bindValue(1, $this->nome);
      $query->bindValue(2, $this->telefone);
      $query->execute();
      if ($query->rowCount() == 1){
        $dado = $query->fetch(PDO::FETCH_ASSOC);
        $this->idContato = $dado['id_contato'];
        $query2 = $this->db->prepare("INSERT INTO tb_contatos_usuarios (id_user, id_contato) 
        VALUES (?, ?)");
        $query2->bindValue(1, $this->idUsuario);
        $query2->bindValue(2, $this->idContato);
        $query2->execute();
        $this->db->commit();
        return true;
      }
    } catch (PDOException $e) {
      $this->db->rollBack();
      echo $e->getMessage();
      return false;
    }

  }
}


