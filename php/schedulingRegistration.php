<?php
  
  function insertPerson($connection){
    $patient = htmlspecialchars(trim($_POST["name"]));
    $cpf = htmlspecialchars(trim($_POST["cpf"]));
    $gender = $_POST["gender"];
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $birthday = $_POST["birthday"];

    $birthday = date('Y-m-d', strtotime($birthday)); // Converte a data para o formato Y-m-d

    $sql = <<<SQL
      INSERT INTO Person (name, cpf, gender, phone, birthday)
      VALUES (?, ?, ?, ?, ?)
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssss", $patient, $cpf, $gender, $phone, $birthday);
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

    $loginId = $connection->insert_id; // captura o id gerado na criação do novo login

    return $loginId;
  }

  function getEmployeeId($connection){

    $professional = $_POST["professional"];

    // $sql = <<<SQL
    //   SELECT p.id FROM Person p
    //   INNER JOIN Employee e ON e.person_id = p.id
    //   WHERE e.id = ?;
    // SQL;

    // $stmt = $connection->prepare($sql);
    // $stmt->bind_param("i", $professional);

    // if(!$stmt->execute()) throw new Exception("Falha na consulta do profissional");

    // $result = $stmt->get_result();

    //return $result->fetch_assoc();

    return $professional;
  }

  function getSpecialtyId(){

    $specialtyId = $_POST["specialty"] ?? "";

    return $specialtyId;
  }

  function insertPatient($connection, $personId, $employeeId, $loginId){

    $sql = <<<SQL
      INSERT INTO Patient (person_id, employee_id, login_id)
      VALUES (?, ?, ?)
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iii", $personId, $employeeId, $loginId);
    if(!$stmt->execute()) throw new Exception("Falha na primeira inserção");

    $patientId = $connection->insert_id;

    return $patientId;
  }

  function insertSheduling($connection, $patientId, $employeeId, $specialtyId){

    $consultationDate = $_POST["consultationDate"];
    $consultationTime = $_POST["consultationTime"];

    $sql = <<<SQL
      INSERT INTO Scheduling (consultation_date, consultation_time, patient_id, employee_id, specialty_id)
      VALUES (?, ?, ?, ?, ?)
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssiii", $consultationDate, $consultationTime, $patientId, $employeeId, $specialtyId);
    if(!$stmt->execute()) throw new Exception("Falha na inserção da tabela Scheduling");

    $schedulingId = $connection->insert_id;

    return $schedulingId;
  }

  try {

    include_once("../database/conexaoMySQL.php");

    $connection = mysqlConnect();

    $connection->begin_transaction();

    $personId = insertPerson($connection);
    
    $loginId = insertLogin($connection);

    $employeeId = getEmployeeId($connection);

    $patientId = insertPatient($connection, $personId, $employeeId, $loginId);

    $specialtyId = getSpecialtyId();

    insertSheduling($connection, $patientId, $employeeId, $specialtyId);

    $connection->commit();

    header("Location: scheduling.php");
    exit();

  } catch (Exception $e) {
    $connection->rollback();
    exit('Rollback executado: ' . $e->getMessage());
  }
?>