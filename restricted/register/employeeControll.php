<?php 

  // FUNÇÕES DE INSERÇÃO 
  function insertPerson($connection, $loginId){

    $name = htmlspecialchars(trim($_POST["name"] ?? ""));
    $cpf = htmlspecialchars(trim($_POST["cpf"] ?? ""));
    $gender = htmlspecialchars(trim($_POST["gender"] ?? ""));
    $phone = htmlspecialchars(trim($_POST["phone"] ?? ""));
    $birthday = htmlspecialchars(trim($_POST["birthday"] ?? ""));

    $birthday = date('Y-m-d', strtotime($birthday)); // Converte a data para o formato Y-m-d

    $status = "Ativo";

    $sql = <<<SQL
      INSERT INTO Person (name, cpf, gender, phone, birthday, status, login_id)
      VALUES (?, ?, ?, ?, ?, ?, ?)
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssssi", $name, $cpf, $gender, $phone, $birthday, $status, $loginId);
    if(!$stmt->execute()) throw new Exception("Falha na primeira inserção");

    $personId = $connection->insert_id;

    return $personId;
  }

  function insertLogin($connection){

    $email = htmlspecialchars(trim($_POST["email"] ?? ""));
    $password = htmlspecialchars(trim($_POST["password"] ?? ""));
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = <<<SQL
      INSERT INTO Login (email, password_hash)
      VALUES (?, ?)
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $email, $passwordHash);
    if(!$stmt->execute()) throw new Exception("Falha na segunda inserção");

    $loginId = $connection->insert_id; // captura o id gerado na criação do novo funcionario

    return $loginId;
  }

  function insertEmployee($connection, $personId, $specialtyId){

    $contractStart = htmlspecialchars(trim($_POST["contract_start"] ?? ""));
    $wage = htmlspecialchars(trim($_POST["wage"] ?? ""));
    $cro = htmlspecialchars(trim($_POST["cro"] ?? ""));
    
    $contractStart = date('Y-m-d', strtotime($contractStart)); // Converte a data para o formato Y-m-d

    $sql = <<<SQL
      INSERT INTO Employee (contract_start, wage, cro, person_id, specialty_id)
      VALUES (?, ?, ?, ?, ?)
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sdsii", $contractStart, $wage, $cro, $personId, $specialtyId);
    if(!$stmt->execute()) throw new Exception("Falha na quarta inserção");

    $employeeId = $connection->insert_id; // captura o id gerado na criação do novo funcionario

    return $employeeId;
  }

  function insertAddressBase($connection, $employeeId){

    $cep = htmlspecialchars(trim($_POST["cep"] ?? ""));
    $uf = htmlspecialchars(trim($_POST["uf"] ?? ""));
    $city = htmlspecialchars(trim($_POST["city"] ?? ""));
    $neighborhood = htmlspecialchars(trim($_POST["neighborhood"] ?? ""));
    $street = htmlspecialchars(trim($_POST["street"] ?? ""));
    $number = htmlspecialchars(trim($_POST["number"] ?? ""));

    $sql5 = <<<SQL
      INSERT INTO AddressBase(cep, uf, city, neighborhood, street, number, employee_id)
      VALUES (?, ?, ?, ?, ?, ?, ?)
    SQL;

    $stmt5 = $connection->prepare($sql5);
    $stmt5->bind_param("sssssii", $cep, $uf, $city, $neighborhood, $street, $number, $employeeId);
    if(!$stmt5->execute()) throw new Exception("Falha na quinta inserção");
  }

  function getSpecialtyId($connection){

    $specialtyId = $_POST["specialty"] ?? "";

    return $specialtyId;
  }

  try {
    // CONEXAO COM O BANCO DE DADOS
    include_once("../../database/conexaoMySQL.php");

    $connection = mysqlConnect();

    // INICIA A TRANSACAO
    $connection->begin_transaction();

    $loginId = insertLogin($connection);

    $personId = insertPerson($connection, $loginId);

    $specialtyId = getSpecialtyId($connection);

    $employeeId = insertEmployee($connection, $personId, $specialtyId);

    insertAddressBase($connection, $employeeId);

    $connection->commit();

    header("Location: employee.php");

    exit();

  } catch (Exception $e) {

    $connection->rollback();
    exit('Rollback executado: ' . $e->getMessage());

  }
?>
