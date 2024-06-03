<?php 
  require "../database/conexaoMySQL.php";

  class RequestResponse {
    public $success;
    public $detail;

    function __construct($success, $detail) {
      $this->success = $success;
      $this->detail = $detail;
    }
  }

  function checkLogin($pdo, $email, $password) {

    $sql = <<<SQL
      SELECT passwordHash
      FROM Login
      WHERE email = ?
      SQL;

    try {
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$email]);
      $passwordHash = $stmt->fetchColumn();

      if(!$passwordHash) 
        return false; 
      
      if(!password_verify($password, $passwordHash)) 
        return false;

      return true;

    } catch (Exception $e) {
      exit('Falha inesperada: ' . $e->getMessage());
    }
  }

  $email = htmlspecialchars(trim($_POST["email"] ?? ""));
  $password = htmlspecialchars(trim($_POST["password"] ?? ""));

  $pdo = mysqlConnect();

  if(checkLogin($pdo, $email, $password)){
    $cookieParams = session_get_cookie_params();
    $cookieParams['httponly'] = true;
    session_set_cookie_params($cookieParams);

    // Criando uma nova sessao para o usuario
    session_start();
    $_SESSION['loggedIn'] = true;
    $_SESSION['user'] = $email;
    $response = new RequestResponse(true, 'restricted/home.php');
  } else {
    $response = new RequestResponse(false, '');
  }

  echo json_encode($response);
?>