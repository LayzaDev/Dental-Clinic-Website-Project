<?php

  include_once("../../database/conexaoMySQL.php");

  $connection = mysqlConnect();

  session_start();

  if((!isset($_SESSION['email']) == true))
  {
    unset($_SESSION['email']);
    header("Location: ../../php/login.php");
  }

  $logado = $_SESSION['email'];

  $sql = <<<SQL
    SELECT 
      p.id, p.name, p.cpf, p.phone, l.email,
      e.contract_start, e.wage, e.cro, s.specialty, 
      a.city, a.uf
    FROM Person p
    INNER JOIN Employee e ON e.person_id = p.id
    INNER JOIN Login l ON e.login_id = l.id
    INNER JOIN Specialty s ON e.specialty_id = s.id
    INNER JOIN AddressBase a ON a.employee_id = e.id
    ORDER BY id
  SQL;

  $result = $connection->query($sql);
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
      text-align: center;
    } 
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary p-3 mb-3">
    <div class="container">
      <h3 class="navbar-brand mx-auto">Funcionários Cadastrados</h3> 
    </div>
    <div class="d-flex">
      <a href="../home.php" class="btn btn-danger me-5">Voltar</a>
    </div>
  </nav>
  <div class="m-4">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nome</th>
          <th scope="col">CPF</th>
          <th scope="col">Telefone</th>
          <th scope="col">Email</th>
          <th scope="col">Início do contrato</th>
          <th scope="col">Salário</th>
          <th scope="col">CRO</th>
          <th scope="col">Especialidade</th>
          <th scope="col">Cidade</th>
          <th scope="col">Estado</th>
          <th scope="col">...</th>
        </tr>
      </thead>
      <tbody>
        <?php
          while($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['Profissional']}</td>";
            echo "<td>{$row['cpf']}</td>";
            echo "<td>{$row['phone']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['contract_start']}</td>";
            echo "<td>{$row['wage']}</td>";
            echo "<td>{$row['cro']}</td>";
            echo "<td>{$row['specialty']}</td>";
            echo "<td>{$row['city']}</td>";
            echo "<td>{$row['uf']}</td>";
            echo "<td>
              <a class='btn btn-sm btn-primary' href='#'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'> 
                  <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                </svg>
              </a>
              <a class='btn btn-sm btn-danger' href='#'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-lg' viewBox='0 0 16 16'>
                  <path d='M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z'/>
                </svg>
              </a>
            </td>";
            echo"</tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>