<?php

  function mysqlConnect(){

    $db_host = "localhost";
    $db_username = "root";
    $db_password = "1977";
    $db_name = "realsmile";
    $db_port = 3306;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {

      $connection = new mysqli($db_host, $db_username, $db_password, $db_name, $db_port);
      $connection->set_charset("utf8mb4");

      return $connection;

    } catch (mysqli_sql_exception $e){  

      error_log($e->getMessage());
      exit("Falha na conexão com o MySQL.");

    }
  }
?>
