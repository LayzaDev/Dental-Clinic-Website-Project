<?php

  include_once("../../database/conexaoMySQL.php");

  $connection = mysqlConnect();

  session_start();

  if((!isset($_SESSION['email']) == true))
  {
    unset($_SESSION['email']);
    header("Location: ../../login.html");
  }

  $logado = $_SESSION['email'];

  $sql = <<<SQL
    SELECT 
      A.id, 
      A.name, 
      A.cpf, 
      A.phone, 
      B.email,
      C.contract_start, 
      C.wage, 
      C.cro, 
      D.specialty, 
      E.city, 
      E.uf, 
      A.status
    FROM Person A
    JOIN Login B 
      ON A.login_id = B.id
    JOIN Employee C 
      ON A.id = C.person_id
    JOIN Specialty D 
      ON C.specialty_id = D.id
    JOIN AddressBase E 
      ON C.id = E.employee_id
    ORDER BY A.id
  SQL;

  $result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Restrita</title>

  <link rel="stylesheet" href="../css/listing.css">

  <!-- 2: Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
  <header>
    <h1>Funcionários Cadastrados</h1> 
    <a href="../home.php"class="material-symbols-outlined">logout</a>
  </header>
  <div class=".table-responsive{-sm|-md|-lg|-xl}">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nome</th>
          <th scope="col">CPF</th>
          <th scope="col">Telefone</th>
          <th scope="col">Email</th>
          <th scope="col">Contratação</th>
          <th scope="col">Salário</th>
          <th scope="col">CRO</th>
          <th scope="col">Área</th>
          <th scope="col">Cidade</th>
          <th scope="col">UF</th>
          <th scope="col">Status</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php
          while($data = $result->fetch_assoc()){
            echo "<tr>";
            echo "<td>{$data['id']}</td>";
            echo "<td>{$data['name']}</td>";
            echo "<td>{$data['cpf']}</td>";
            echo "<td>{$data['phone']}</td>";
            echo "<td>{$data['email']}</td>";
            echo "<td>{$data['contract_start']}</td>";
            echo "<td>{$data['wage']}</td>";
            echo "<td>{$data['cro']}</td>";
            echo "<td>{$data['specialty']}</td>";
            echo "<td>{$data['city']}</td>";
            echo "<td>{$data['uf']}</td>";
            echo "<td>{$data['status']}</td>";
            echo "<td>
              <a class='btn btn-sm btn-primary' href='../controll/employee/formEmployee.php?id=$data[id]'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'> 
                  <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                </svg>
              </a>
              <a class='btn btn-sm btn-danger' href='../controll/employee/cancelEmployee.php?id=$data[id]'>
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
    <footer>&copy Real Smile</footer>
  </div>
</body>
</html>
