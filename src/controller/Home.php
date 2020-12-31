<?php
namespace Source\controller;
use Source\model\UsuarioModel;
session_start();

class Home
{
  private $dir;

  public function __construct($router)
  {
    $this->router = $router;
    $this->dir = 'src/view/';
  }


  public function view($data)
  {
    $foto = '';
    $contatos = array();
    if (isset($_SESSION['login'])) {  
      $usuario = new UsuarioModel();
      $foto = $usuario->getFotoPerfil($_SESSION['login']);
      $contatos = $usuario->listAllContacts($_SESSION['login']);
    }
    require $this->dir.'home.php';
  }

  public function redirect($endereco): void
  {
      $this->router->redirect($endereco);
  }
}