<?php
  include_once("../../../database/conexaoMySQL.php");

  $connectionDB = mysqlConnect();

  $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

  if($id == 0) {
    die ("ID inválido");
  }

  try {

    $connectionDB->begin_transaction();

    $sql = "SELECT status FROM Scheduling WHERE id = ?";

    $stmt = $connectionDB->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $scheduling = $result->fetch_assoc();

    $newStatus = ($scheduling['status'] === "Ativo") ? "Inativo" : "Ativo";

    $sql = "UPDATE Scheduling SET status = ? WHERE id = ?";
    $stmt = $connectionDB->prepare($sql);
    $stmt->bind_param("si", $newStatus, $id);
    $stmt->execute();

    $connectionDB->commit();

    header("Location: ../../listing/listOfSchedulings.php");

  } catch (Exception $e) {
    $connectionDB->rollback();
    exit('Rollback executado: ' . $e->getMessage());
  }
?>