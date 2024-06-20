<?php
  include_once("../database/conexaoMySQL.php");

  $connection = mysqlConnect();

  $sql = <<<SQL
    SELECT * FROM Specialty
    ORDER BY id
  SQL;

  $result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agendamentos</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/scheduling.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <header>
    <img src="../image/logotipo.jpeg" alt="logo">
    <a href="../login.html">Restrito</a>
  </header>
  <nav>
    <ul>
      <li><a href="../index.html">Inicio</a></li>
      <li><a href="../structure.html">Estrutura</a></li>
      <li><a href="../treatments.html">Tratamentos</a></li>
      <li><a href="#">Agendamento</a></li>
    </ul>
  </nav>
  <main class="container">
      <form id="formScheduling" action="schedulingRegistration.php" method="POST">
        <h2>Agendamentos</h2>
        <fieldset class="form-fieldset">
          <legend>Dados da Consulta</legend>
            <div class="row ">
              <div class="form-group col-8 col-md-4">
                <label class="form-label" for="specialty">Especialidade:</label>
                <select name="specialty" id="specialty" class="form-select" required>
                  <option value="">Selecione</option>
                  <?php
                    while($row = $result->fetch_assoc()){
                      echo '<option value="' . $row['id'] . '">' . $row['specialty'] . '</option>';
                    } 
                  ?>
                </select>
              </div>
              <div class="form-group col-8 col-md-4">
                <label class="form-label" for="professional">Profissional:</label>
                <select name="professional" id="professional" class="form-select" required>
                <!-- opções -->
                </select>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-8 col-md-4">
                <label class="form-label" for="consultationDate">Data da Consulta:</label>
                <input type="date" name="consultationDate" id="consultationDate" class="form-control" required>
              </div>
              <div class="form-group col-8 col-md-4">
                <label class="form-label" for="consultationTime">Horário:</label>
                <select name="consultationTime" id="consultationTime" class="form-select" required>
                  <option selected>Selecione</option>
                  <option value="08:00">08:00</option>
                  <option value="09:30">09:30</option>
                  <option value="10:00">10:00</option>
                  <option value="11:00">11:00</option>
                  <option value="13:00">13:00</option>
                  <option value="15:00">15:00</option>
                </select>
              </div>
            </div>
        </fieldset>
        <fieldset>
          <legend>Dados do Paciente</legend>
            <div class="row">
              <div class="form-group col-8 col-md-5">
                <label class="form-label" for="name">Nome do Paciente:</label>
                <input type="text" id="name" name="name" class="form-control" required>
              </div>
              <div class="form-group col-8 col-md-3">
                <label class="form-label" for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" class="form-control" required>
              </div>
              
            </div>
            <div class="row">
              <div class="form-group col-8 col-md-5">
                <label class="form-label" for="email">E-mail:</label>
                <input type="email" id="email" name="email" class="form-control" required>
              </div>
              <div class="form-group col-8 col-md-3">
                <label class="form-label" for="password">Senha:</label>
                <input type="password" id="password" name="password" class="form-control" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-8 col-md-3">
                <label class="form-label" for="gender">Sexo:</label>
                <select name="gender" id="gender" class="form-select" required>
                  <option value="">Selecione</option>
                  <option value="M">Masculino</option>
                  <option value="F">Feminino</option>
                  <option value="N/I">Prefiro não informar</option>
                </select>
              </div>
              <div class="form-group col-8 col-md-3">
                <label class="form-label" for="phone">Telefone:</label>
                <input type="tel" id="phone" name="phone" placeholder="34 99999-9999" pattern="[0-9]{2} [0-9]{5}-[0-9]{4}" maxlength="13" class="form-control" required>
              </div>
              
              <div class="form-group col-8 col-md-2">
                <label class="form-label" for="birthday">Data de Nascimento:</label>
                <input type="date" id="birthday" name="birthday" class="form-control" required>
              </div>
            </div>
        </fieldset>
        <div class="button">
          <button class="btn btn-success btn-lg">Agendar</button>
        </div>
      </form>
  </main>
  <script src="../js/sheduling.js"></script>
  <!-- <script>
      const form = document.querySelector('#formScheduling');

      form.onsubmit = (e) => {
        e.preventDefault();
      }
  </script> -->
</body>
</html>
