<?php
  include_once("../../../database/conexaoMySQL.php");

  $connectionDB = mysqlConnect();

  $id = $_GET["id"] ?? ""; // id do agendamento

  $sql = <<<SQL
    SELECT 
      A.id,
      A.consultation_date, 
      A.consultation_time,
      C.name AS name_patient,
      E.name AS name_employee,
      F.specialty
    FROM Scheduling A
    INNER JOIN Patient B
      ON A.patient_id = B.id
    INNER JOIN Person C
      ON B.person_id = C.id
    INNER JOIN Employee D
      ON A.employee_id = D.id
    INNER JOIN Person E
      ON D.person_id = E.id
    INNER JOIN Specialty F
      ON D.specialty_id = F.id
    WHERE A.id = ?
  SQL;

  $stmt = $connectionDB->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 0) {
    die("Paciente não encontrado");
  }

  $data = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edição</title>
  <link rel="stylesheet" href="../../css/register.css">
</head>
<body>
  <header>
    <img src="../../../image/logotipo.jpeg" alt="logo">
  </header>
  <hr>
  <main>
    <form id="formScheduling" action="editScheduling.php?id=<?php echo $id; ?>" method="post">
      <fieldset>
        <legend>Atualizar dados da consulta</legend>
        <div class="wrapper">
            <div class="item col-12">
              <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($data['name_patient']); ?>" required>
              <label class="labelInput" for="name">Nome</label>
            </div>
            <div class="item col-6">
              <label for="consultationDate" class="labelSelect">Data da Consulta</label>
              <input class="inputs" type="date" name="consultationDate" id="consultationDate" value="<?php echo htmlspecialchars($data['consultation_date']); ?>" required>
            </div>
            <div class="item col-6">
              <label for="consultationTime" class="labelSelect">Horário</label>
              <input type="time" name="consultationTime" id="consultationTime" value="<?php echo htmlspecialchars($data['consultation_time']); ?>">
            </div>
            <div class="item col-6">
              <label for="specialty" class="labelSelect">Especialidade</label>
              <select name="specialty" id="specialty" onchange="loadSelectProfessionals()">
                <option value="">Selecione</option>
                <?php
                  $sqlSpecialty = "SELECT * FROM Specialty ORDER BY id";
                  $resultSpecialty = $connectionDB->query($sqlSpecialty);

                  while($row = $resultSpecialty->fetch_assoc()){
                    $selected = $row['id'] == $data['specialty_id'] ? 'selected' : '';
                    echo <<<HTML
                      <option value="{$row['id']}" $selected>{$row['specialty']}</option>
                    HTML;
                  }
                ?>
              </select>
            </div>
            <div class="item col-6">
              <label for="professional" class="labelSelect">Profissional</label>
              <select name="professional" id="professional" value="<?php echo htmlspecialchars($data['name_employee']); ?>">
                <option value="">Selecione</option>
              </select>
            </div>
        </div>
      </fieldset>
      <div class="btn">
        <a href="../../listing/listOfSchedulings.php">Cancelar</a>
        <button type="submit">Agendar</button>
      </div>
    </form>
  </main>
  <footer>
    <p>&copy By Layza Nauane</p>
  </footer>
  <script src="../../../js/searchProfessionals.js"></script>
  <script src="../../../js/loadProfessionals.js"></script>
</body>
</html>

