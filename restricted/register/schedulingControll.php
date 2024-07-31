<?php
  
  function insertPerson($connection, $loginId){
    $patient = htmlspecialchars(trim($_POST["name"]));
    $cpf = htmlspecialchars(trim($_POST["cpf"]));
    $gender = htmlspecialchars(trim($_POST["gender"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $birthday = $_POST["birthday"];

    $birthday = date('Y-m-d', strtotime($birthday)); // Converte a data para o formato Y-m-d

    $status = "Ativo";

    $sql = <<<SQL
      INSERT INTO Person (name, cpf, gender, phone, birthday, status, login_id)
      VALUES (?, ?, ?, ?, ?, ?, ?)
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssssi", $patient, $cpf, $gender, $phone, $birthday, $status, $loginId);
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
    $professional = $_POST["professional"] ?? "";
    return $professional;
  }

  function getSpecialtyId(){
    $specialty = $_POST["specialty"] ?? "";
    return $specialty;
  }

  function insertPatient($connection, $personId, $employeeId){

    $sql = <<<SQL
      INSERT INTO Patient (person_id, employee_id)
      VALUES (?, ?)
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $personId, $employeeId);
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

    include_once("../../database/conexaoMySQL.php");

    $connection = mysqlConnect();

    $connection->begin_transaction();
    
    $loginId = insertLogin($connection);

    $personId = insertPerson($connection, $loginId);

    $employeeId = getEmployeeId($connection);

    $patientId = insertPatient($connection, $personId, $employeeId);

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