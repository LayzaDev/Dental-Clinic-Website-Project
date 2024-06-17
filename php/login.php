<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/login.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
</head>
<body>
  <header>
    <img src="../image/logotipo.jpeg" alt="logo">
  </header>
  <nav>
    <ul>
      <li><a href="../index.html">Início</a></li>
      <li><a href="../structure.html">Estrutura</a></li>
      <li><a href="../treatments.html">Tratamentos</a></li>
      <li><a href="../scheduling.html">Agendamentos</a></li>
    </ul>
  </nav>
  <main>
    <h2>Login</h2>
    <form id="formLogin" action="loginControl.php" method="post">
      <div>
        <label for="email" class="labels">E-mail</label>
        <input type="email" name="email" id="email" class="inputs" placeholder="user@gmail.com">
        <span class="validationSpan"></span>
      </div>
      <div>
        <label for="password" class="labels">Senha</label>
        <input type="password" name="password" id="password" class="inputs" placeholder="*********">
        <span class="validationSpan"></span>
      </div>
      <input class="inputSubmit" type="submit" name="submit" value="Entrar">
      <div class="col-sm-12 d-grid">
        <p id="loginFailMsg">Dados incorretos. Por favor, tente novamente.</p>
      </div> 
    </form>
  </main>
  <script src="js/login.js"></script>
</body>
</html>
