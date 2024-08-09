<?php
  session_start();

  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);

  if(isset($request->email) && isset($request->password))
  {
    include_once("../database/conexaoMySQL.php");

    $connection = mysqlConnect();

    $email = $request->email;
    $password = $request->password;

    $sql = "SELECT email, password_hash FROM Login WHERE email = ?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows < 1){
      unset($_SESSION['email']);
      echo json_encode(['success' => false]);
    } else {
      $row = $result->fetch_assoc();
      $passwordHash = $row['password_hash'];

      if(password_verify($password, $passwordHash)){
        $_SESSION['email'] = $email;
        echo json_encode(['success' => true]);
      } else {
        echo json_encode(['success' => false]);
      }
    }
  } else {
    echo json_encode(['success' => false]);
  }
?>
