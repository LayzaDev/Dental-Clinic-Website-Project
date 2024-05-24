<?php

  function mysqlConnect(){
    $db_host = "sql110.infinityfree.com";
    $db_username = "if0_36439084";
    $db_password = "realsmileclinic";
    $db_name = "if0_36439084_realsmile";
    $db_port = "3306";

    $options = [
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    try {
      $url = "mysql:host=$db_host;port=$db_port;dbname=$db_name";
      $pdo = new PDO($url, $db_username, $db_password, $options);
      return $pdo;
    } catch (Exception $e) {
      exit("Falha na conexão com o MySQL: " . $e->getMessage());
    }
  }
?>