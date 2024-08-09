<?php 
  include_once("../../../database/conexaoMySQL.php");

  $connectionDB = mysqlConnect();

  $id = isset($_GET['id']) ? (int)$_GET['id'] : 0; // id do scheduling

  if($id == 0) {
    die ("ID inválido");
  }

  function updatePatientName($id, $connectionDB){ 
    $name = htmlspecialchars(trim($_POST['name'] ?? ""));

    $sql = <<<SQL
      UPDATE Person A
      JOIN Patient B 
        ON A.id = B.person_id
      JOIN Scheduling C 
        ON B.id = C.patient_id
      SET A.name= ?
      WHERE C.id = $id
    SQL;
    
    $stmt = $connectionDB->prepare($sql);
    $stmt->bind_param("s", $name);
    if(!$stmt->execute()) throw new Error("Erro ao executar a 1° consulta SQL");
  }

  function updateScheduling($id, $connectionDB){ 
    $date = htmlspecialchars(trim($_POST['consultationDate'] ?? ""));
    $time = htmlspecialchars(trim($_POST['consultationTime'] ?? ""));
    $specialtyId = htmlspecialchars(trim($_POST['specialty'] ?? ""));
    $employeeId = htmlspecialchars(trim($_POST['professional'] ?? ""));

    $sql = <<<SQL
      UPDATE Scheduling
      SET consultation_date = ?, consultation_time = ?, employee_id = ?, specialty_id = ?
      WHERE id = $id
    SQL;
    
    $stmt = $connectionDB->prepare($sql);
    $stmt->bind_param("ssii", $date, $time, $specialtyId, $employeeId);
    if(!$stmt->execute()) throw new Error("Erro ao executar a 2° consulta SQL");
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    updatePatientName($id, $connectionDB);
    updateScheduling($id, $connectionDB);

    header("Location: ../../listing/listOfSchedulings.php");
    exit();
  }

  $sql = <<<SQL
    SELECT 
      A.id,
      A.consultation_date, 
      A.consultation_time,
      A.employee_id,
      A.specialty_id
    FROM Scheduling A
    WHERE A.id = $id
  SQL;
  
  $result = $connectionDB->query($sql);

?>