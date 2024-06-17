<?php

  session_start();

  if((!isset($_SESSION['email']) == true)){
    unset($_SESSION['email']);
    header("location: ../php/login.php");
  }

  $logado = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restrita</title>
  <link rel="stylesheet" href="css/index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <header>
    <div>
      <img src="../image/logotipo.jpeg" alt="logo">
    </div>
    <div class="divh3">
      <h3>Restricted Area</h3>
    </div>
    <div class="divLink">
      <a href="../php/sair.php">Sair</a>
    </div>
  </header>
  <main>
    <div id="buttons">
      <div class="row">
        <div class="col-12 col-md-4 divBtn">
          <a href="register/employeeRegistration.php" class="btn">Cadastrar Funcionário</a>
        </div>
        <div class="col-12 col-md-8 divDesc">
          <p>Clique para cadastrar um novo funcionário no sistema</p>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-4 divBtn">
          <a href="listing/listOfMyPatients.php" class="btn">Meus pacientes</a>
        </div>
        <div class="col-12 col-md-8 divDesc">
          <p>Clique para visualizar seus pacientes</p>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-4 divBtn">
          <a href="listing/listOfSchedulings.php" class="btn">Meus Agendamentos</a>
        </div>
        <div class="col-12 col-md-8 divDesc">
          <p>Clique para visualizar seus agendamentos</p>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-4 divBtn">
          <a href="listing/listOfPatients.php" class="btn">Listagem de Pacientes</a>
        </div>
        <div class="col-12 col-md-8 divDesc">
          <p>Clique para visualizar os pacientes da Real Smile</p>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-4 divBtn">
          <a href="listing/listOfEmployees.php" class="btn">Listagem de Funcionários</a>
        </div>
        <div class="col-12 col-md-8 divDesc">
          <p>Clique para visualizar os funcionarios da Real Smile</p>
        </div>
      </div>
    </div>
  </main>
  <footer>
    <address>
      <p>&copy; Todos os direitos são reservados à Real Smile.</p>
    </address>
  </footer>
</body>
</html>
