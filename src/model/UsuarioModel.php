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

  public function listAllContacts($idUser) {
    try {
      $query = $this->db->prepare("SELECT id_user as id_contato, nome, email, foto_perfil, (
        select mensagem from tb_mensagem inner join (
        SELECT id_remetente, id_destinatario, MAX(data_msg) as data_m from tb_mensagem 
        group by id_remetente, id_destinatario having 
        tb_mensagem.id_remetente = ? and tb_mensagem.id_destinatario = id_user or
        tb_mensagem.id_remetente = id_user and tb_mensagem.id_destinatario = ?
        order by data_m desc limit 1) b on b.data_m = tb_mensagem.data_msg
        ) ultima_mensagem
        FROM tb_usuario t_c
        right JOIN (
                SELECT id_contato, id_user as my_id from tb_contatos_usuarios where id_user = ?
        ) t_c_u
        ON t_c_u.id_contato = t_c.id_user");
      $query->bindValue(1, $idUser);
      $query->bindValue(2, $idUser);
      $query->bindValue(3, $idUser);
      $query->execute();
      if ($query->rowCount() > 0) {
        return $query->fetchAll(PDO::FETCH_ASSOC);
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getFotoPerfil($id) {
    try {
      $query = $this->db->prepare("SELECT id_user, foto_perfil, nome, email from tb_usuario WHERE id_user = ?");
      $query->bindValue(1, $id);
      $query->execute();
      if ($query->rowCount() == 1) {
        $dados = $query->fetch(PDO::FETCH_ASSOC);
        return $dados;
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

}