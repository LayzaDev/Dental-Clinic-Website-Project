<?php
  include_once("../../../database/conexaoMySQL.php");

  $connectionDB = mysqlConnect();

  $id = $_GET["id"] ?? "";

  try {

    $connectionDB->begin_transaction();

    $sql = "SELECT status FROM Person WHERE id = ?";

    $stmt = $connectionDB->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $person = $result->fetch_assoc();

    $newStatus = ($person['status'] === "Ativo") ? "Inativo" : "Ativo";

    $sql = "UPDATE Person SET status = ? WHERE id = ?";
    $stmt = $connectionDB->prepare($sql);
    $stmt->bind_param("si", $newStatus, $id);
    $stmt->execute();

    $connectionDB->commit();

    header("Location: ../../listing/listOfEmployees.php");

  } catch (Exception $e) {
    $connectionDB->rollback();
    exit('Rollback executado: ' . $e->getMessage());
  }
?>