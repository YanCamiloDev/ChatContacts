<?php

namespace Source\controller;
use Source\model\UsuarioModel;
session_start();

class Chat {
  
  private $router;
  private $dir;

  public function __construct($router)
  {
    $this->router = $router;
    $this->dir = 'src/view/';
  }

  public function view ($data) {
    $contatos = array();
    if (isset($_SESSION['login'])) {  
      $usuario = new UsuarioModel();
      $contatos = $usuario->listAllContacts($_SESSION['login']);
    }
    require $this->dir.'chat.php';
  }

  public function redirect($endereco) {
    $this->router->redirect($endereco);
  }
}