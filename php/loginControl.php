<?php
  session_start();

  if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['password']))
  {
    include_once("../database/conexaoMySQL.php");

    $connection = mysqlConnect();

    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";

    $sql = "SELECT email, password_hash FROM Login WHERE email = ?";
    print_r("Teste");
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {

      unset($_SESSION['email']);
      header("Location: login.php");

    } else {

      $row = $result->fetch_assoc();

      $passwordHash = $row['password_hash'];

      if (password_verify($password, $passwordHash)) {

        $_SESSION['email'] = $email;
        header("Location: ../restricted/home.php");

      } else {
        header("Location: login.php");
      }
    }
  } else {
    header("Location: login.php");
  }

?>
