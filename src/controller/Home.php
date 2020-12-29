<?php
namespace Source\controller;

class Home
{
  private $dir;

  public function __construct($router)
  {
    $this->router = $router;
    $this->dir = 'src/view/';
  }


  public function home($data)
  {
    require $this->dir.'home.php';
  }

  public function redirect($endereco): void
  {
      $this->router->redirect($endereco);
  }
}