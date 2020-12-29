<?php require "src/global/links.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="assets/css/addcontato.css">
  <title>Adicionar Contato</title>
</head>
<body>
  <div class="container">
    <div class="container-main">
      <aside>
        <label class="rounded" for="image">
          <img id="imm" src="assets/imagens/foto.png" alt="Foto de perfil">
        </label>
      </aside>
      <aside>
        <form action="addContato" method="POST" id="cadForm" enctype="multipart/form-data">
          <h1>Cadastre um novo contato</h1>
          <input style="display: none;" name="arquivo" id="image" type="file" alt="Perfil">
          <input type="text" id="nome" name="nome" placeholder="Nome">
          <input type="text" id="telefone" name="telefone" placeholder="Telefone">
          <input type="submit" value="Salvar Contato" id="btCadastro" name="acaoCadastro">
        </form>
      </aside>
    </div>
  </div>
  <script src="assets/js/components/cadastro.js"></script>
</body>
</html>