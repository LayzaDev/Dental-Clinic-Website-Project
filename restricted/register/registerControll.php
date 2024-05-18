<?php 
  require "../../database/conexaoMySQL.php";

  $pdo = mysqlConnect();

  // Dados da tabela Pessoa
  $name = $_POST["username"] ?? "";
  $cpf = $_POST["cpf"] ?? "";
  $sex = $_POST["sex"] ?? "";
  $email = $_POST["email"] ?? "";
  $phone = $_POST["phone"] ?? "";
  $birthday = $_POST["birthday"] ?? "";

  // Dados da tabela Funcionario
  $hiringDate = $_POST["hiringDate"] ?? "";
  $wage = $_POST["wage"] ?? "";
  $cro = $_POST["cro"] ?? "";
  $specialty = $_POST["specialty"] ?? "";

  // Dados da tabela Login
  $password = $_POST["password"] ?? "";
  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  // Dados da tabela endereco
  $cep = $_POST["cep"] ?? "";
  $uf = $_POST["state"] ?? "";
  $locality = $_POST["locality"] ?? "";
  $neighborhood = $_POST["neighborhood"] ?? "";
  $street = $_POST["street"] ?? "";
  $houseNumber = $_POST["houseNumber"] ?? "";

  // Insere no banco de dados
  $sql1 = <<<SQL
    INSERT INTO Person (username, cpf, sex, email, phone, birthday)
    VALUES (?, ?, ?, ?, ?, ?)
  SQL;

  $sql2 = <<<SQL
    INSERT INTO Employee (hiringDate, wage, cro, specialty, personId)
    VALUES (?, ?, ?, ?, ?)
  SQL;

  $sql3 = <<<SQL
    INSERT INTO Login (email, passwordHash, employeeId)
    VALUES (?, ?, ?)
  SQL;

  $sql4 = <<<SQL
    INSERT INTO AddressBase(cep, uf, locality, neighborhood, street, houseNumber, employeeId)
    VALUES (?, ?, ?, ?, ?, ?, ?)
  SQL;

  // faz a transacao
  try {
    $pdo->beginTransaction();

    $stmt1 = $pdo->prepare($sql1);
    if(!$stmt1->execute([
      $name, 
      $cpf, 
      $sex, 
      $email, 
      $phone, 
      $birthday
    ])) throw new Exception("Falha na primeira inserção");

    $personId = $pdo->lastInsertId();

    $stmt2 = $pdo->prepare($sql2);
    if(!$stmt2->execute([
      $hiringDate,
      $wage,
      $cro,
      $specialty,
      $personId
    ])) throw new Exception("Falha na segunda inserção");

    $employeeId = $pdo->lastInsertId();

    $stmt3 = $pdo->prepare($sql3);
    if(!$stmt3->execute([
      $email,
      $passwordHash,
      $employeeId
    ])) throw new Exception("Falha na terceira inserção");

    $stmt4 = $pdo->prepare($sql4);
    if(!$stmt4->execute([
      $cep,
      $uf,
      $locality, 
      $neighborhood,
      $street, 
      $houseNumber,
      $employeeId
    ])) throw new Exception("Falha na quarta inserção");

    $pdo->commit();

  } catch (Exception $e) {
    $pdo->rollback();
    exit('Rollback executado: ' . $e->getMessage());
  }
?>