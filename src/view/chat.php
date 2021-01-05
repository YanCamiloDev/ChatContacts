<!DOCTYPE html>
<html lang="br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link
    href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;500;700&display=swap"
    rel="stylesheet"
  />
  <link rel="stylesheet" type="text/css" 
  href="http://localhost/projetos/Agenda/assets/css/chat.css">
  <title>Chat</title>
</head>
<body>
  <div class="container">
    <div class="chatContainer">
      <div id="contatosList" class="contatosList">
        <header>
          <div id="info" class="info">
          </div>
          <div class="search">
            <img src="assets/imagens/search.png" alt="">
            <input id="pesquisaInput" type="text" placeholder="Pesquisar Contato">
          </div>
        </header>
        <?php foreach($contatos as $contato): ?>
          <button 
            value="<?= $contato['id_contato'] ?>" 
            id="<?= $contato['id_contato'] ?>" 
            onclick="conectar(<?= $contato['id_contato'] ?>)" 
            class="contato">
            <img src="storage/perfil/ <?= $contato['foto_perfil']?>" alt="" srcset="">
            <div class="nomeAndLastMsg">
              <h2><?= $contato['nome'] ?></h2>
              <h4><?= $contato['ultima_mensagem'] ?></h4>
            </div>
          </button>        
        <?php endforeach; ?>
      </div>
      <form id="formConversa" class="conversa">
        <div id="chatConversa" class="chatConversa">
        </div>
        <input id="mensagemInput" type="text" placeholder="Digite sua mensagem">
      </form>
    </div>
  </div>
  <script src="http://localhost/projetos/Agenda/assets/js/jquery.js"></script>
  <script src="http://localhost/projetos/Agenda/assets/js/bib/autobahn.js"></script>
  <script src="http://localhost/projetos/Agenda/assets/js/chat.js"></script>
</body>
</html>