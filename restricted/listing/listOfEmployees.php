<?php
  require "../database/conexaoMySQL.php";
  require "../php/sessionVerification.php";

  session_start();
  exitWhenNotLoggedIn();

  $pdo = mysqlConnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restrita</title>

  <!-- 2: Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

  <style>
    body {
      padding-top: 2rem;
    }

    img {
      width: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h3>Funcionários Cadastrados</h3> 
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <tr>
          <th class="dt-center">Id</th>
          <th class="dt-center">Nome</th>
          <th class="dt-center">CPF</th>
          <th class="dt-center">Telefone</th>
          <th class="dt-center">Email</th>
          <th class="dt-center">Data do contrato</th>
          <th class="dt-center">Salário</th>
          <th class="dt-center">CRO</th>
          <th class="dt-center">Especialidade</th>
          <th class="dt-center">Cidade</th>
          <th class="dt-center">Estado</th>
        </tr>

        <?php
          foreach($arrayEmployee as $employee){
            echo <<<HTML
              <tr>
                <td><a href="controller.php?acao=deleteEmployee&cpf=$employee->cpf">Excluir</a></td>
                <td>$employee->id</td>
                <td>$employee->username</td>
                <td>$employee->cpf</td>
                <td>$employee->phone</td>
                <td>$employee->email</td>
                <td>$employee->hiringDate</td>
                <td>$employee->wage</td>
                <td>$employee->cro</td>
                <td>$employee->specialty</td>
              </tr>
            HTML;
          }

          foreach($arrayAddressBase as $address){
            echo <<<HTML
              <tr>
                <td>$address->locality</td>
                <td>$address->uf</td>
              </tr>
            HTML;
          }
        ?>
      </table>
    </div>
  </div>
</body>
</html>