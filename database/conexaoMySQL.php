<?php

  function mysqlConnect(){

    $db_host = "sql110.infinityfree.com";
    $db_username = "if0_36439084";
    $db_password = "realsmileclinic";
    $db_name = "if0_36439084_realsmile";
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
