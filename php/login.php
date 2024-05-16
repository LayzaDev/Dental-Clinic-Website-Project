<?php 

  function checkLogin($pdo, $email, $password) {

    $sql = <<<SQL
      SELECT l.passwordHash
      FROM Login l 
      INNER JOIN Employee e
      ON e.id = l.idEmployee
      WHERE email = ?
    SQL;

    try {

      $stmt = $pdo->prepare($sql);
      $stmt->execute([$email]);
      $row = $stmt->fetch();

      if(!$row) return false; 
      
      return password_verify($password, $row['passwordHash']);

    } catch (Exception $e) {
      exit('Falha inesperada ao tentar fazer o login: ' . $e->getMessage());
    }
  }

  require "../database/conexaoMySQL.php";
  $pdo = mysqlConnect();

  $email = $_POST["email"] ?? "";
  $password = $_POST["password"] ?? "";

  if(checkLogin($pdo, $email, $password)){
    header("location: ../restricted/");
  } else {
    header("location: ../login.html");
  }
?>