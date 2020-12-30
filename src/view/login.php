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
  <link rel="stylesheet" type="text/css" href="assets/css/login.css">
  <title>Login</title>
</head>
<body>
  <?php if (isset($importante)): ?>
    <div class="aviso">
      <h4>Logue no Sistema</h4>
    </div>
  <?php endif; ?>
  <div class="container">
    <div class="container-main">
      <aside>
        <form action="login" method="POST">
          <h1>Entrar</h1>
          <input type="text" id="email" name="email" placeholder="Email">
          <input type="password" id="senha" name="senha" placeholder="Senha">
          <input type="submit" value="Entrar" id="btEntrar" name="acaoLogar">
        </form>
        <a href="cadastro">Cadastrar-se</a>
      </aside>
    </div>
  </div>
</body>
</html>