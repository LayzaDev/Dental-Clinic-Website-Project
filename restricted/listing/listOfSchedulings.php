<?php

  include_once("../../database/conexaoMySQL.php");

  $connection = mysqlConnect();

  session_start();

  if((!isset($_SESSION['email']) == true))
  {
    unset($_SESSION['email']);
    header("Location: ../../php/login.php");
  }

  $logado = $_SESSION['email'];;

  $sql = <<< SQL
    SELECT 
      s.id,
      (SELECT p1.name FROM Person p1 
       JOIN Patient pt ON pt.person_id = p1.id 
       WHERE pt.id = s.patient_id) 
       AS patient,
      s.consultation_date, 
      s.consultation_time, 
      (SELECT p2.name FROM Person p2 
       JOIN Employee e ON e.person_id = p2.id 
       WHERE e.id = s.employee_id) 
       AS employee,
      (SELECT sp.specialty FROM Specialty sp 
       WHERE sp.id = s.specialty_id) 
       AS specialty
    FROM Scheduling s
    ORDER BY s.id
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
    <h3>Funcionários Cadastrados</h3> 
    <a href="../home.php"class="material-symbols-outlined">logout</a>
  </header>
  <div class=".table-responsive{-sm|-md|-lg|-xl}">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Paciente</th>
          <th scope="col">Data da Consulta</th>
          <th scope="col">Horário</th>
          <th scope="col">Profissional</th>
          <th scope="col">Especialidade</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php
          while($data = mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>{$data['id']}</td>";
            echo "<td>{$data['patient']}</td>";
            echo "<td>{$data['consultation_date']}</td>";
            echo "<td>{$data['consultation_time']}</td>";
            echo "<td>{$data['employee']}</td>";
            echo "<td>{$data['specialty']}</td>";
            echo "<td>
              <a class='btn btn-sm btn-primary' href='#'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                  <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                </svg>
              </a>
              <a class='btn btn-sm btn-danger' href='#'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-lg' viewBox='0 0 16 16'>
                  <path d='M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L7.293 8z'/>
                </svg>
              </a>
            </td>";
            echo "</tr>";
          }
        ?>
      </tbody>
    </table>
    <footer>&copy Real Smile</footer>
  </div>
</body>
</html>
