<?php
  include_once("../../database/conexaoMySQL.php");

  $connection = mysqlConnect();

  session_start();
  
  if((!isset($_SESSION['email'])) == true)
  {
    unset($_SESSION['email']);
    header("Location: ../../login.html");
  }

  $logado = $_SESSION['email'];

  $sql = <<<SQL
    SELECT * FROM Specialty
    ORDER BY id
  SQL;

  $result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restrita</title>

    <!-- Links CSS -->
    <link rel="stylesheet" href="../../css/index.css" />
    <link rel="stylesheet" href="../css/register.css"> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

</head>
<body>
  <header>
    <img src="../../image/logotipo.jpeg" alt="logo">
    <a href="../home.php" class="material-symbols-outlined">logout</a>
  </header>
  <hr>
  <main>  
    <form id="registrationForm" action="employeeControll.php" method="POST">
      <fieldset>
        <legend>Cadastro de Funcionários</legend>
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
          <div class="item col-3">
            <label class="labelSelect" for="contract_start" >Início do Contrato</label>
            <input type="date" name="contract_start" id="contract_start">
          </div>
          <div class="item item-special col-3">
            <input type="text" id="cro" name="cro" required>
            <label class="labelInput" for="cro">CRO</label>
          </div>
          <div class="item item-special col-3">
            <input type="number" id="wage" name="wage" required>
            <label class="labelInput" for="wage">Salário</label>
          </div>
          <div class="item col-3">
            <label for="specialty" class="labelSelect">Especialidade</label>
            <select name="specialty" id="specialty" required>
              <option value="">Selecione</option>
              <?php
                while($row = $result->fetch_assoc()){
                  echo '<option value="' . $row['id'] . '">' . $row['specialty'] . '</option>';
                } 
              ?>
            </select>
          </div>
          <div class="item col-4">
            <input type="text" id="cep" name="cep" pattern="[0-9]{5}-[0-9]{3}" required>
            <label class="labelInput" for="cep">CEP</label>
          </div>
          <div class="item col-8">
            <input type="text" id="street" name="street" required>
            <label class="labelInput" for="street">Logradouro</label>
          </div>
          <div class="item col-4">
            <input type="number" id="number" name="number" pattern="[0-9]{5}-[0-9]{3}" required>
            <label class="labelInput" for="number">Número</label>
          </div>
          <div class="item col-8">
            <input type="text" id="city" name="city" required>
            <label class="labelInput" for="city">Cidade</label>
          </div>  
          <div class="item col-4">
            <label for="uf" class="labelSelect">Estado</label>
            <select name="uf" id="uf">
              <option value="">Selecione</option>
              <option value="AC">AC</option>
              <option value="AL">AL</option>
              <option value="AP">AP</option>
              <option value="AM">AM</option>
              <option value="BA">BA</option>
              <option value="CE">CE</option>
              <option value="DF">DF</option>
              <option value="ES">ES</option>
              <option value="GO">GO</option>
              <option value="MA">MA</option>
              <option value="MT">MT</option>
              <option value="MS">MS</option>
              <option value="MG">MG</option>
              <option value="PA">PA</option>
              <option value="PB">PB</option>
              <option value="PR">PR</option>
              <option value="PE">PE</option>
              <option value="PI">PI</option>
              <option value="RJ">RJ</option>
              <option value="RN">RN</option>
              <option value="RS">RS</option>
              <option value="RO">RO</option>
              <option value="RR">RR</option>
              <option value="SC">SC</option>
              <option value="SP">SP</option>
              <option value="SE">SE</option>
              <option value="TO">TO</option>
            </select>
          </div>
          <div class="item item-special col-8">
            <input type="text" id="neighborhood" name="neighborhood" required>
            <label class="labelInput" for="neighborhood">Bairro</label>
          </div>
        </div>
      </fieldset>
      <div class="btn">
        <a href="../home.php">Cancelar</a>
        <button type="submit" id="btnRegister">Cadastrar</button>
      </div>
    </form>
  </main>
  <script src="../../js/ajax.js"></script>
</body>
</html>
