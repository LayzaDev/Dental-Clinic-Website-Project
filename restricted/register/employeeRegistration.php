<?php

  include_once("../../database/conexaoMySQL.php");

  $connection = mysqlConnect();

  session_start();
  
  if((!isset($_SESSION['email'])) == true)
  {
    unset($_SESSION['email']);
    header("Location: ../../php/login.php");
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
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/register.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <header>
    <div>
      <img src="../../image/logotipo.jpeg" alt="logo">
    </div>
    <div class="divh3">
      <h3>Cadastro de Funcionários</h3>
    </div>
    <div class="divLink">
      <a href="../home.php">Voltar</a>
    </div>
  </header>
  <main class="container">  
      <form id="registrationForm" action="employeeControll.php" method="POST">
          <fieldset>
              <legend>Dados Pessoais</legend>
              <div class="row">
                <div class="form-group col-9 col-md-6">
                  <label for="name">Nome</label>
                  <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group col-9 col-md-3">
                  <label for="cpf">CPF</label>
                  <input type="text" name="cpf" id="cpf" class="form-control" placeholder="000.000.000-00">
                </div> 
              </div>
              <div class="row">
                <div class="form-group col-9 col-md-3">
                  <label for="gender">Sexo</label>
                  <select name="gender" id="gender" class="form-control">
                      <option value="">Selecione</option>
                      <option value="M">Masculino</option>
                      <option value="F">Feminino</option>
                      <option value="N">Prefiro não informar</option>
                  </select>
                </div>
                <div class="form-group col-9 col-md-3">
                  <label for="birthday">Data de Nascimento</label>
                  <input type="date" name="birthday" id="birthday" class="form-control">
                </div>
                <div class="form-group col-9 col-md-3">
                  <label for="phone">Telefone</label>
                  <input type="tel" name="phone" id="phone" class="form-control" placeholder="(00) 00000-0000" pattern="[0-9]{2} [0-9]{5}-[0-9]{4}">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-9 col-md-6">
                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="user@gmail.com">
                </div>
                <div class="form-group col-9 col-md-3">
                  <label for="password">Senha</label>
                  <input type="password" name="password" id="password" class="form-control">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-9 col-md-2">
                  <label for="hiringDate">Início do contrato</label>
                  <input type="date" name="hiringDate" id="hiringDate" class="form-control">
                </div>
                <div class="form-group col-9 col-md-2">
                  <label for="wage">Salário</label>
                  <input type="number" name="wage" id="wage" class="form-control" step=".01" placeholder="0,00">
                </div>
                <div class="form-group col-9 col-md-2 medico">
                    <label for="cro">CRO</label>
                    <input type="text" class="form-control" name="cro" id="cro">
                  </div>
                  <div class="form-group col-9 col-md-3 medico">
                    <label for="specialty">Especialidade</label>
                    <select name="specialty" id="specialty" class="form-select">
                      <option value="">Selecione</option>
                      <?php
                        while($row = $result->fetch_assoc()){
                          echo '<option value="' . $row['id'] . '">' . $row['specialty'] . '</option>';
                        } 
                      ?>
                    </select>
                  </div>
              </div>
          </fieldset>
          <fieldset>
              <legend>Endereço</legend>
              <div class="row">
                <div class="form-group col-9 col-md-2">
                    <label for="cep">CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control" placeholder="00000-000" pattern="[0-9]{5}-[0-9]{3}">
                </div>
                <div class="form-group col-9 col-md-5">
                    <label for="street">Logradouro</label>
                    <input type="text" name="street" id="street" class="form-control">
                </div>
                <div class="form-group col-9 col-md-2">
                    <label for="houseNumber">Numero</label>
                    <input type="text" name="houseNumber" id="houseNumber" class="form-control">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-9 col-md-2">
                  <label for="uf">Estado</label>
                  <select name="uf" id="uf" class="form-select">
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
                <div class="form-group col-9 col-md-4">
                  <label for="city">Cidade</label>
                  <input type="text" name="city" id="city" class="form-control">
                </div>
                <div class="form-group col-9 col-md-3">
                  <label for="neighborhood">Bairro</label>
                  <input type="text" name="neighborhood" id="neighborhood" class="form-control">
                </div>
              </div>
          </fieldset>
          <div class="divBtn">
              <button class="btn btn-success btn-lg">Cadastrar</button>
          </div>
      </form>
  </main>
  <footer>
      <p>&copy; Todos os direitos são reservados à Vitalize.</p>
  </footer>
  <script src="ajax.js"></script>
  <script>
      const form = document.querySelector('#formCad');

      form.onsubmit = (e) => {
        e.preventDefault();
      }
  </script>
</body>
</html>
