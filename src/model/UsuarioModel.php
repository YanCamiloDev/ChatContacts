<?php
namespace Source\model;

use PDO;
use PDOException;
use Source\config\DbConfig;

class UsuarioModel extends DbConfig{

  private $nome;
  private $email;
  private $senha;
  private $foto;

  public function __construct($nome="", $email="", $senha="", $foto="")
  {
    $this->nome = $nome;
    $this->email = $email;
    $this->senha = $senha;
    $this->foto = $foto;
    parent::__construct();    
  }

  /**
   * Função responsável por logar o usuário
   * @param String $this->email
   * @param String $this->senha
   * 
   * @return Array array("status", "msg", "conteudo")
   */
  public function logar() {
    $query = $this->db->prepare("SELECT id_user, senha FROM tb_usuario WHERE email = ?");
    $query->bindValue(1, $this->email);
    $query->execute();
    if ($query->rowCount() == 1) {
      $dados = $query->fetch(PDO::FETCH_ASSOC);
      if (password_verify($this->senha, $dados['senha'])) {
       return array("status" => 200, "msg" => "autorizado", "conteudo" => $dados['id_user']); 
      }else
       return array("status" => 400, "msg" => "Senha Incorreta"); 
    } else {
      return array("status" => 400, "msg" => "Email Incorreto"); 
    }
  }

  public function getFotoPerfil($id) {
    try {
      $query = $this->db->prepare("SELECT foto_perfil from tb_usuario WHERE id_user = ?");
      $query->bindValue(1, $id);
      $query->execute();
      if ($query->rowCount() == 1) {
        $dados = $query->fetch(PDO::FETCH_ASSOC);
        return $dados['foto_perfil'];
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

}