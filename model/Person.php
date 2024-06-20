<?php

  include_once("../database/conexaoMySQL.php");

  $connection = mysqlConnect();

  $name = htmlspecialchars(trim($_POST["name"] ?? ""));
  $cpf = htmlspecialchars(trim($_POST["cpf"] ?? ""));
  $gender = htmlspecialchars(trim($_POST["gender"] ?? ""));
  $phone = htmlspecialchars(trim($_POST["phone"] ?? ""));
  $birthday = htmlspecialchars(trim($_POST["birthday"] ?? ""));

  $birthday = date('Y-m-d', strtotime($birthday)); // Converte a data para o formato Y-m-d

  function insertPerson($connection){

    $sql = <<<SQL
      INSERT INTO Person (name, cpf, gender, phone, birthday)
      VALUES (?, ?, ?, ?, ?)
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssss", $name, $cpf, $gender, $phone, $birthday);
    if(!$stmt->execute()) throw new Exception("Falha na primeira inserção");

    $personId = $connection->insert_id;

    return $personId;
  }
?>