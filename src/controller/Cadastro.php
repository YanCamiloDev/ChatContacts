<?php
namespace Source\controller;

use Source\model\CadastroModel;
use Source\util\UploadFoto;

class Cadastro
{
  private $dir;
  private $router;

  public function __construct($router) {
    $this->router = $router;
    $this->dir = 'src/view/';
  }

  /**
   * Função responsável por exibir a página home na tela
   * 
   * @param Array $data
   * @return void
   */
  public function cadastro($data)
  {
    require $this->dir.'cadastro.php';
  }

  /**
   * Função responsável por intermediar o processo de cadastro
   * entre a view o model
   * 
   * @param Array $data
   * @return void
   */
  public function cadastrar($data){
    $cadastroModel = new CadastroModel();
    $uploadImage = new UploadFoto();
    $foto = $_FILES;
    $nomeDaFoto = $uploadImage->upLoadFoto($foto);
    if ($nomeDaFoto['status'] == 200) {
      $resultado = $cadastroModel->saveUser(
        $data['nome'], 
        $data['email'], 
        $data['senha'], 
        $nomeDaFoto['retorno']);
        $this->router->redirect("");
    } else {
      $resultado = $nomeDaFoto['retorno'];
    }
    require $this->dir.'cadastro.php';
  }

  
  /**
   * Função responsável por redirecionar para qualquer página 
   * registrada nas rotas
   * 
   * @param String $endereco
   * @return void
   */
  public function redirect($endereco): void
  {
    $this->router->redirect($endereco);
  }
}