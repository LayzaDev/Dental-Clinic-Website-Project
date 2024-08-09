<?php 
  include_once("../../../database/conexaoMySQL.php");

  $connectionDB = mysqlConnect();

  $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

  if($id == 0) {
    die ("ID inválido");
  }

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

  function updateEmployeeId($id, $connectionDB) {
    $employeeId = htmlspecialchars(trim($_POST['professional']));

    $sql3 = <<<SQL
      UPDATE Patient p
      SET p.employee_id = ?
      WHERE p.person_id = $id
    SQL;

    $stmt3 = $connectionDB->prepare($sql3);
    $stmt3->bind_param("i", $employeeId);
    if(!$stmt3->execute()) throw new Error("Erro ao executar a 3° consulta SQL");
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    updatePerson($id, $connectionDB);
    updateLogin($id, $connectionDB);
    updateEmployeeId($id, $connectionDB);

    header("Location: ../../listing/listOfPatients.php");
    exit();
  }

?>