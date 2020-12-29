<?php require "src/global/links.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="assets/css/home.css">
  <title>Home</title>
</head>
<body>
  <div class="container">
    <header>
      <div class="details">
        <img id="foto" src="<?php echo "storage/perfil/ ".$foto; ?>"/>
        <h1>Home</h1>
      </div>
      <nav>
        <ul>
          <li><a href="login">Contatos</a></li>
          <li><a href="addContato">Adicionar Contato</a></li>
          <li><a href="chat">Chat</a></li>
          <?php if (isset($_SESSION['login'])): ?>
          <li><a id="sair" onclick="deslogar();" href="javascript:;">Sair</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </header>
    
    <main class="main">
      <div class="container-main">
        <?php if (!isset($_SESSION['login'])): ?>
        <h1><a href="login" >Entrar</a></h1>
        <?php endif; ?>
      </div>
    </main>
  </div>

  <script src="assets/js/jquery.js"></script>

  <script>
    function deslogar() {
      $.ajax({
        url: 'http://localhost/projetos/Agenda/deslogar',
        type: 'GET',
        success: function (result) {
          const dados = JSON.parse(result);
          const { resultado } = dados;
          if (resultado == "OK") {
            document.location.reload(true);
          }
        },
        error: (err) => {
          console.log(err);
        },
      });
    }
  </script>
</body>
</html>