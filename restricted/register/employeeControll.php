<?php 
  require "../../database/conexaoMySQL.php";

  $pdo = mysqlConnect();

  // Dados da tabela Pessoa
  $username = htmlspecialchars(trim($_POST["username"] ?? ""));
  $cpf = htmlspecialchars(trim($_POST["cpf"] ?? ""));
  $sex = htmlspecialchars(trim($_POST["sex"] ?? ""));
  $email = htmlspecialchars(trim($_POST["email"] ?? ""));
  $phone = htmlspecialchars(trim($_POST["phone"] ?? ""));
  $birthday = htmlspecialchars(trim($_POST["birthday"] ?? ""));

  // Dados da tabela Funcionario
  $hiringDate = htmlspecialchars(trim($_POST["hiringDate"] ?? ""));
  $wage = htmlspecialchars(trim($_POST["wage"] ?? ""));
  $cro = htmlspecialchars(trim($_POST["cro"] ?? ""));
  $specialty = htmlspecialchars(trim($_POST["specialty"] ?? ""));

  // Dados da tabela Login
  $password = htmlspecialchars(trim($_POST["password"] ?? ""));
  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  // Dados da tabela endereco
  $cep = htmlspecialchars(trim($_POST["cep"] ?? ""));
  $uf = htmlspecialchars(trim($_POST["state"] ?? ""));
  $locality = htmlspecialchars(trim($_POST["locality"] ?? ""));
  $neighborhood = htmlspecialchars(trim($_POST["neighborhood"] ?? ""));
  $street = htmlspecialchars(trim($_POST["street"] ?? ""));
  $houseNumber = htmlspecialchars(trim($_POST["houseNumber"] ?? ""));

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
      $username, 
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