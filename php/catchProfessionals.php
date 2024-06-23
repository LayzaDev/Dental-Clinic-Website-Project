<?php

  include_once("../database/conexaoMySQL.php");

  $connection = mysqlConnect();

  $specialtyId = intval($_GET['specialtyValue']);

  if(isset($specialtyId)){
    
    $sql = <<<SQL
      SELECT 
        e.id, p.name
      FROM Person p 
      INNER JOIN Employee e ON e.person_id = p.id
      WHERE e.specialty_id = ?
      ORDER BY e.id
    SQL;

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $specialtyId);
    
    if(!$stmt->execute()) throw new Exception("Falha na consulta do profissional");

    $result = $stmt->get_result();
    $professionals = array();

    while($row = $result->fetch_assoc()){
      $professionals[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($professionals);
  } else {
    echo json_encode(["error" => "SpecialtyId invalido"]);
  }
?>