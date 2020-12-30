<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;500;700&display=swap"
    rel="stylesheet"
  />
  <link rel="stylesheet" type="text/css" href="assets/css/HomeStyle.css">
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
        <?php if (isset($_SESSION['login']) && isset($dados)): ?>
        <div class="contatos">
          <?php for($i=0; $i <20; $i++): ?>
          <div class="contato">
            <img src="assets/imagens/foto.png" alt="" srcset="">
            <h2>79999371769</h2>
          </div>
          <?php endfor; ?>
        </div>
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