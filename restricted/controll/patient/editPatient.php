<?php 
  include_once("../../../database/conexaoMySQL.php");

  $connectionDB = mysqlConnect();

  $id = $_GET['id'] ?? "";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = htmlspecialchars(trim($_POST['name'] ?? ""));
    $cpf = htmlspecialchars(trim($_POST['cpf'] ?? ""));
    $gender = htmlspecialchars(trim($_POST['gender'] ?? ""));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ""));
    $birthday = htmlspecialchars(trim($_POST['birthday'] ?? ""));

    $email = htmlspecialchars(trim($_POST['email'] ?? ""));

    $specialtyId = htmlspecialchars(trim($_POST['specialty'] ?? ""));

    $sql1 = <<<SQL
      UPDATE Person
      SET name = ?, cpf = ?, gender = ?, phone = ?, birthday = ?
      WHERE id = $id
    SQL;
    
    $stmt1 = $connectionDB->prepare($sql1);
    $stmt1->bind_param("sssss", $name, $cpf, $gender, $phone, $birthday);
    if(!$stmt1->execute()) throw new Error("Erro ao executar a 1° consulta SQL");

    $sql2 = <<<SQL
      UPDATE Login l
      SET l.email = ?
      WHERE l.id = (SELECT p.login_id FROM Person p WHERE p.id = $id)
    SQL;
    
    $stmt2 = $connectionDB->prepare($sql2);
    $stmt2->bind_param("s", $email);
    if(!$stmt2->execute()) throw new Error("Erro ao executar a 2° consulta SQL");

    

    header("Location: ../../listing/listOfEmployees.php");
    exit();
  }

  $sql = <<<SQL
    SELECT 
      p.id, p.name, p.cpf, p.phone, p.birthday, l.email,
      (SELECT p1.name FROM Person p1 
       JOIN Employee e ON p1.id = e.person_id
       JOIN Specialty s ON s.id = e.specialty_id
       WHERE e.id = pt.employee_id) 
      AS professional,
      (SELECT s.specialty FROM Specialty s 
       JOIN Employee e ON s.id = e.specialty_id
       WHERE e.id = pt.employee_id) 
      AS field,
      p.status
    FROM Person p
    INNER JOIN Patient pt ON pt.person_id = p.id
    INNER JOIN Login l ON l.id = p.login_id
    ORDER BY p.id
    LIMIT 1
  SQL;
  
  $result = $connectionDB->query($sql);

?>