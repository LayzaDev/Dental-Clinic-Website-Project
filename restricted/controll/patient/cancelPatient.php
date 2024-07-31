<?php
  include_once("../../database/conexaoMySQL.php");
  $connectionDB = mysqlConnect();

  $id = $_GET["id"] ?? "";

  try {

    $connectionDB->begin_transaction();

    $sql = <<<SQL
      UPDATE Person
      SET Status = "Inativo"
      WHERE id = ?
    SQL;

    $stmt = $connectionDB->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $connectionDB->commit();
    header("Location: ../../listing/listOfPatients.php");

  } catch (Exception $e) {
    $connectionDB->rollback();
    exit('Rollback executado: ' . $e->getMessage());
  }
?>