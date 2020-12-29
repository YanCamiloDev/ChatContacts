<?php

namespace Source\util;

use Symfony\Component\HttpFoundation\File\File;

class UploadFoto{

  private $dir;

  public function __construct()
  {
    $this->dir = getcwd()."\storage\perfil\ ";
  }

  /**
   * Responsável por gravar uma foto no diretório do servidor
   * @param File $foto
   * @return Array $resultado
   */
  public function upLoadFoto($foto){
    $arquivo_tmp = $foto[ 'arquivo' ][ 'tmp_name' ];
    $nome = $foto[ 'arquivo' ][ 'name' ];
    $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
    $extensao = strtolower ( $extensao );

    if ( strstr ( '.jpg;.jpeg;.gif;.png', $extensao ) ) {
      $novoNome = uniqid ( time () ) . '.' . $extensao;

      $destino = $this->dir.$novoNome;
      if (move_uploaded_file($arquivo_tmp, $destino)) {
        $resultado = array("status" => 200, "retorno" => $novoNome);
        return $resultado;
      }
      else {
        $resultado = array("status" => 400, "retorno" => "Erro ao salvar o arquivo");
        return $resultado;
      }
    }
    else{
      $resultado = array(
        "status" => 400, 
        "retorno" => 'Você poderá enviar apenas arquivos "*.jpg;*.jpeg;*.gif;*.png"');
      return $resultado;
    }
  }
 
}
