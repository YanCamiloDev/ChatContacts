<?php

namespace Source\controller;

class Chat {
  
  private $router;
  private $dir;

  public function __construct($router)
  {
    $this->router = $router;
    $this->dir = 'src/view/';
  }

  public function view ($data) {
    require $this->dir.'chat.php';
  }

  public function redirect($endereco) {
    $this->router->redirect($endereco);
  }
}