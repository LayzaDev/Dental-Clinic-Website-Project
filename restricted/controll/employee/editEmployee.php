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
      UPDATE Login A
      SET A.email = ?
      WHERE A.id = (SELECT B.login_id FROM Person B WHERE B.id = $id)
    SQL;
    
    $stmt2 = $connectionDB->prepare($sql2);
    $stmt2->bind_param("s", $email);
    if(!$stmt2->execute()) throw new Error("Erro ao executar a 2° consulta SQL");
  }

  function updateEmployee($id, $connectionDB){
    $contractStart = htmlspecialchars(trim($_POST['contract_start'] ?? ""));
    $wage = htmlspecialchars(trim($_POST['wage'] ?? ""));
    $cro = htmlspecialchars(trim($_POST['cro'] ?? ""));
    $specialtyId = htmlspecialchars(trim($_POST['specialty'] ?? ""));

    $sql3 = <<<SQL
      UPDATE Employee
      SET contract_start = ?, wage = ?, cro = ?, specialty_id = ?
      WHERE person_id = $id
    SQL;
    
    $stmt3 = $connectionDB->prepare($sql3);
    $stmt3->bind_param("sdsi", $contractStart, $wage, $cro, $specialtyId);
    if(!$stmt3->execute()) throw new Error("Erro ao executar a 3° consulta SQL");
  }

  function updateAddress($id, $connectionDB){
    $cep = htmlspecialchars(trim($_POST['cep'] ?? ""));
    $uf = htmlspecialchars(trim($_POST['uf'] ?? ""));
    $city = htmlspecialchars(trim($_POST['city'] ?? ""));
    $neighborhood = htmlspecialchars(trim($_POST['neighborhood'] ?? ""));
    $street = htmlspecialchars(trim($_POST['street'] ?? ""));
    $number = htmlspecialchars(trim($_POST['number'] ?? ""));

    $sql4 = <<<SQL
      UPDATE AddressBase A
      SET A.cep = ?, A.uf = ?, A.city = ?, A.neighborhood = ?, A.street = ?, A.number = ?
      WHERE A.employee_id = (SELECT B.id FROM Employee B WHERE B.person_id = $id)
    SQL;
    
    $stmt4 = $connectionDB->prepare($sql4);
    $stmt4->bind_param("sssssi", $cep, $uf, $city, $neighborhood, $street, $number);
    if(!$stmt4->execute()) throw new Error("Erro ao executar a 3° consulta SQL");
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    updatePerson($id, $connectionDB);
    updateLogin($id, $connectionDB);    
    updateEmployee($id, $connectionDB);
    updateAddress($id, $connectionDB);

    header("Location: ../../listing/listOfEmployees.php");
    exit();
  }


?>