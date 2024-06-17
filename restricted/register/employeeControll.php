<?php 

  // FUNÇÕES DE INSERÇÃO 
  function insertPerson($connection){

    $name = htmlspecialchars(trim($_POST["name"] ?? ""));
    $cpf = htmlspecialchars(trim($_POST["cpf"] ?? ""));
    $gender = htmlspecialchars(trim($_POST["gender"] ?? ""));
    $phone = htmlspecialchars(trim($_POST["phone"] ?? ""));
    $birthday = htmlspecialchars(trim($_POST["birthday"] ?? ""));

    $birthday = date('Y-m-d', strtotime($birthday)); // Converte a data para o formato Y-m-d

    $sql = <<<SQL
      INSERT INTO Person (name, cpf, gender, phone, birthday)
      VALUES (?, ?, ?, ?, ?)
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssss", $name, $cpf, $gender, $phone, $birthday);
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

  function insertEmployee($connection, $personId, $loginId, $specialtyId){

    $contractStart = htmlspecialchars(trim($_POST["contract_start"] ?? ""));
    $wage = htmlspecialchars(trim($_POST["wage"] ?? ""));
    $cro = htmlspecialchars(trim($_POST["cro"] ?? ""));
    
    $contractStart = date('Y-m-d', strtotime($contractStart)); // Converte a data para o formato Y-m-d

    $sql = <<<SQL
      INSERT INTO Employee (contract_start, wage, cro, person_id, login_id, specialty_id)
      VALUES (?, ?, ?, ?, ?, ?)
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sdsiii", $contractStart, $wage, $cro, $personId, $loginId, $specialtyId);
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
    $houseNumber = htmlspecialchars(trim($_POST["houseNumber"] ?? ""));

    $sql5 = <<<SQL
      INSERT INTO AddressBase(cep, uf, city, neighborhood, street, number, employee_id)
      VALUES (?, ?, ?, ?, ?, ?, ?)
    SQL;

    $stmt5 = $connection->prepare($sql5);
    $stmt5->bind_param("sssssii", $cep, $uf, $city, $neighborhood, $street, $houseNumber, $employeeId);
    if(!$stmt5->execute()) throw new Exception("Falha na quinta inserção");
  }

  function getSpecialtyId($connection){
    $specialty = htmlspecialchars(trim($_POST["specialty"] ?? ""));

    $sql = <<<SQL
      SELECT s.id FROM Specialty s WHERE s.specialty = ?;
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $specialty);

    if(!$stmt->execute()) throw new Exception("Falha na consulta de especialidade");

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['id'] ?? null;
  }

  try {
    // CONEXAO COM O BANCO DE DADOS
    include_once("../../database/conexaoMySQL.php");

    $connection = mysqlConnect();

    // INICIA A TRANSACAO
    $connection->begin_transaction();

    $personId = insertPerson($connection);

    $loginId = insertLogin($connection);

    $specialtyId = getSpecialtyId($connection);

    $employeeId = insertEmployee($connection, $personId, $loginId, $specialtyId);

    insertAddressBase($connection, $employeeId);

    $connection->commit();

    header("Location: employeeRegistration.php");

    exit();

  } catch (Exception $e) {

    $connection->rollback();
    exit('Rollback executado: ' . $e->getMessage());

  }
?>
