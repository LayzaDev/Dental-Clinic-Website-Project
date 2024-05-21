<?php 

  function checkLogin($pdo, $email, $password) {

    $sql = <<<SQL
      SELECT l.passwordHash
      FROM Login l 
      INNER JOIN Employee e ON e.id = l.employeeId
      WHERE email = ?
    SQL;

    try {

      $stmt = $pdo->prepare($sql);
      $stmt->execute([$email]);
      $row = $stmt->fetch();

      if(!$row) return false; 
      
      return password_verify($password, $row['passwordHash']);

    } catch (Exception $e) {
      error_log('ERROR: ' . $e->getMessage());
      exit('Falha inesperada ao tentar fazer o login.');
    }
  }

  require "../database/conexaoMySQL.php";
  $pdo = mysqlConnect();

  if($pdo === null) exit('Falha ao conectar ao banco de dados.');

  $email = $_POST["email"] ?? "";
  $password = $_POST["password"] ?? "";

  if(checkLogin($pdo, $email, $password)){
    header("location: ../restricted/index.html");
    // exit("Acesso restrito liberado!");
  } else {
    header("location: ../index.html");
    // exit("Erro ao tentar acessar a parte restrita!");
  }
?>