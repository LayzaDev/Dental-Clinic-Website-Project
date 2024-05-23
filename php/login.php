<?php 

  require "../database/conexaoMySQL.php";

  class RequestResponse {
    public $success;
    public $detail;

    function __construct($success, $detail){
      $this->success = $success;
      $this->detail = $detail;
    }
  }

  function checkUserCredentials($pdo, $email, $password) {

    $sql = <<<SQL
      SELECT l.passwordHash
      FROM Login l 
      INNER JOIN Employee e ON e.id = l.employeeId
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

  $email = $_POST["email"] ?? "";
  $password = $_POST["password"] ?? "";

  $pdo = mysqlConnect();

  if($pdo === null) exit('Falha ao conectar ao banco de dados.');

  if(checkUserCredentials($pdo, $email, $password)){
    $cookieParams = session_get_cookie_params();
    $cookieParams['httponly'] = true;
    session_set_cookie_params($cookieParams);

    // Criando uma nova sessao para o usuario
    session_start();
    $_SESSION['loggedIn'] = true;
    $_SESSION['user'] = $email;
    $response = new RequestResponse(true, '../restricted/home.php');
  } else {
    $response = new RequestResponse(false, "");
  }

  echo json_encode($response);
?>