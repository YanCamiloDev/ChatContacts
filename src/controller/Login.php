<?php

namespace Source\controller;
use Source\model\UsuarioModel;
use Symfony\Component\HttpFoundation\JsonResponse;

session_start();

class Login{

  private $dir;
  private $router;

  public function __construct($router)
  {
    $this->router = $router;
    $this->dir = 'src/view/';
  }

  /**
   * Responsável por receber uma requição POST e logar o usuário
   * @param String $data['email', 'senha']
   * @return void
   */

  public function logar($data) {
    $usuarioModel = new UsuarioModel("", $data['email'], $data['senha'], "");
    $response = $usuarioModel->logar();
    if ($response["status"] == 200) {
      $_SESSION['login'] = $response["conteudo"];
      $this->redirect("h.h");
    }else {
      $this->redirect('login.login');
    }
  }

  /**
   * Função responsável por deslogar o usuário
   * @return JsonResponse
   */
  public function deslogar($data) {
    $_SESSION = array();
    session_destroy();
    echo json_encode(array("resultado" => "OK"));
  }

  /**
   * Função responsável por abrir e exibir a página de login
   * @param String $data
   * @return void
   */

  public function view($data) {
    require $this->dir."login.php";
  }

  public function redirect($endereco) {
    $this->router->redirect($endereco);
  }
}