<?php 
  include_once("../../../database/conexaoMySQL.php");

  $connectionDB = mysqlConnect();

  $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
  if($id == 0) die ("ID inválido");

  function updatePerson($id, $connectionDB){ 
    $name = htmlspecialchars(trim($_POST['name'] ?? ""));
    $cpf = htmlspecialchars(trim($_POST['cpf'] ?? ""));
    $gender = htmlspecialchars(trim($_POST['gender'] ?? ""));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ""));
    $birthday = htmlspecialchars(trim($_POST['birthday'] ?? ""));

    $sql1 = <<<SQL
      UPDATE Person
      SET name = ?, cpf = ?, gender = ?, phone = ?, birthday = ?
      WHERE id = $id
    SQL;
    
    $stmt1 = $connectionDB->prepare($sql1);
    $stmt1->bind_param("sssss", $name, $cpf, $gender, $phone, $birthday);
    if(!$stmt1->execute()) throw new Error("Erro ao executar a 1° consulta SQL");
  }

  function updateLogin($id, $connectionDB){
    $email = htmlspecialchars(trim($_POST['email'] ?? ""));

    $sql2 = <<<SQL
      UPDATE Login l
      SET l.email = ?
      WHERE l.id = (SELECT p.login_id FROM Person p WHERE p.id = $id)
    SQL;
    
    $stmt2 = $connectionDB->prepare($sql2);
    $stmt2->bind_param("s", $email);
    if(!$stmt2->execute()) throw new Error("Erro ao executar a 2° consulta SQL");
  }

  function getSpecialtyId($connectionDB){
    $specialtyId = htmlspecialchars(trim($_POST['specialty'] ?? ""));

    return $specialtyId;
  }

  function getEmployeeId($connectionDB) {
    $employeeId = htmlspecialchars(trim($_POST['employee_id']));
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    

    

    

    
    

    header("Location: ../../listing/listOfEmployees.php");
    exit();
  }

  $sql = <<<SQL
    SELECT 
      s.id, 
      p.name, 
      p.cpf, 
      p.gender, 
      p.phone, 
      p.birthday, 
      l.email,
      (SELECT p2.name 
        FROM Person p2 
        JOIN Employee e ON p2.id = e.person_id
        WHERE e.id = pt.employee_id) AS professional,
      (SELECT s.specialty 
        FROM Specialty s
        JOIN Employee e ON s.id = e.specialty_id
        WHERE e.id = pt.employee_id) AS field,
      p.status
    FROM Person p
    JOIN Patient pt ON pt.person_id = p.id
    JOIN Login l ON l.id = p.login_id
    ORDER BY p.id
    LIMIT 1;
  SQL;
  
  $result = $connectionDB->query($sql);

?>