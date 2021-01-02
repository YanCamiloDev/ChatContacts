<?php
namespace Source\controller;

use Source\model\ContatoModel;

session_start();

class Contato {


  private $router;
  private $dir;

  public function __construct($router) {
    $this->router = $router;
    $this->dir = 'src/view/';
  }

  /**
   * Função responsável por renderizar a página em tela
   * @param Array $data
   * @return void
   */

  public function view($data) {
    if (isset($_SESSION['login'])){
      require $this->dir.'addContato.php';
    }else{
      $importante = "Entre primeiro";
      require $this->dir.'login.php';
    }
  }
  
  /**
   * Função responsável por cadastrar um novo contato
   * @param array $data
   * @return void
   */
  public function addContato($data) {
    $contatoModel = new ContatoModel('', $data['email']);
    $result = $contatoModel->saveContact($_SESSION['login'], $data['email']);
    echo var_dump($result);
    if ($result) {
      $this->redirect("h.h");
    }
  }

  public function redirect($endereco) {
    $this->router->redirect($endereco);
  }
}