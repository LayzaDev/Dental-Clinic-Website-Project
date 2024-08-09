<?php
  include_once("../../database/conexaoMySQL.php");

  $connectionDB = mysqlConnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agendamentos</title>
  <link rel="stylesheet" href="../../css/index.css" />
  <link rel="stylesheet" href="../css/register.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
  <header>
    <img src="../../image/logotipo.jpeg" alt="logo">
    <a href="../../index.html" class="material-symbols-outlined">logout</a>
  </header>
  <hr>
  <main>
    <form id="formScheduling" action="schedulingControll.php" method="POST">
      <fieldset>
        <legend>Agendamento</legend>
        <div class="wrapper">
          <div class="item col-8">
            <input type="text" id="name" name="name" required>
            <label class="labelInput" for="name">Nome</label>
          </div>
          <div class="item col-4">
            <input type="text" id="cpf" name="cpf" required>
            <label class="labelInput" for="cpf">CPF</label>
          </div>
          <div class="item col-8">
            <input type="email" id="email" name="email" required>
            <label class="labelInput" for="email">E-mail</label>
          </div>
          <div class="item col-4">
            <input type="password" id="password" name="password" required>
            <label class="labelInput" for="password">Senha</label>
          </div>
          <div class="item col-4">
            <label for="gender" class="labelSelect">Sexo</label>
            <select name="gender" id="gender" required>
                <option value="">Selecione</option>
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
                <option value="N/I">Prefiro não informar</option>
            </select>
          </div>
          <div class="item item-special col-4">
            <input type="tel" id="phone" name="phone" pattern="[0-9]{2} [0-9]{5}-[0-9]{4}" maxlength="13" required>
            <label class="labelInput" for="phone">Telefone</label>
          </div>
          <div class="item col-4">
            <label for="birthday" class="labelSelect">Data de Nascimento</label>
            <input type="date" id="birthday" name="birthday" required>
          </div>
          <div class="item col-6">
            <label for="specialty" class="labelSelect">Especialidade</label>
            <select name="specialty" id="specialty" onchange="loadSelectProfessionals()" required>
              <option value="">Selecione</option>
              <?php
                $sql = "SELECT * FROM Specialty ORDER BY id";
                $result = $connectionDB->query($sql);

                while($row = $result->fetch_assoc()){
                  echo <<<HTML
                    <option value="{$row['id']}" $selected>{$row['specialty']}</option>;
                  HTML;
                } 
              ?>
            </select>
          </div>
          <div class="item col-6">
            <label for="professional" class="labelSelect">Profissional</label>
            <select name="professional" id="professional" required>
            <!-- opções -->
            </select>
          </div>
          <div class="item col-6">
            <label for="consultationDate" class="labelSelect">Data da Consulta</label>
            <input class="inputs" type="date" name="consultationDate" id="consultationDate" required>
          </div>
          <div class="item col-6">
            <label for="consultationTime" class="labelSelect">Horário</label>
            <select name="consultationTime" id="consultationTime" required>
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
      <div class="btn">
        <a href="../../index.html">Cancelar</a>
        <button type="submit">Agendar</button>
      </div>
    </form>
  </main>
  <footer>
    <p>&copy By Layza Nauane</p>
  </footer>
  <script src="../../js/searchProfessionals.js"></script>
  <script src="../../js/loadProfessionals.js"></script>
</body>
</html>
