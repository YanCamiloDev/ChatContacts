<?php
namespace Source\model;

use PDO;
use PDOException;
use Source\config\DbConfig;

class CadastroModel extends DbConfig{

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Função responsável por salvar um usuário no banco de dados
   * @param String $nome
   * @param String $email
   * @param String $senha
   * 
   * @return String $dados
   */
  public function saveUser($nome, $email, $senha, $foto){
    try {
      $query = $this->db->prepare("SELECT id_user FROM tb_usuario WHERE email = ?");
      $query->execute([$email]);
      if ($query->rowCount() == 0) {
        $query = $this->db->prepare("INSERT INTO tb_usuario (nome, email, senha, foto_perfil)
        VALUES (?, ?, ?, ?) RETURNING id_user");
        $query->bindValue(1, $nome);
        $query->bindValue(2, $email);
        $query->bindValue(3, password_hash($senha, PASSWORD_DEFAULT));
        $query->bindValue(4, $foto);
        $query->execute();
        $dados = $query->fetch((PDO::FETCH_ASSOC));
        return $dados;
      }
    } catch (PDOException $e) {
      return $e->getMessage()();
    }
  }

}