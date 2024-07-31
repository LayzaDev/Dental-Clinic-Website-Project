<?php
  include("editPatient.php");
?>

<!DOCTYPE html>
<html lang="en">
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
    <form id="formScheduling" action="editPatient.php?id=<?php echo $id; ?>" method="POST">
      <fieldset>
        <legend>Editar dados do paciente</legend>
        <div class="wrapper">
          <?php
            while ($data = $result->fetch_assoc()) {
          ?>
            <div class="item col-8">
              <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($data['name']); ?>" required>
              <label class="labelInput" for="name">Nome</label>
            </div>
            <div class="item col-4">
              <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($data['cpf']); ?>" required>
              <label class="labelInput" for="cpf">CPF</label>
            </div>
            <div class="item col-8">
              <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required>
              <label class="labelInput" for="email">E-mail</label>
            </div>
            <div class="item col-4">
              <input type="tel" id="phone" name="phone" pattern="[0-9]{2} [0-9]{5}-[0-9]{4}" maxlength="13" value="<?php echo htmlspecialchars($data['phone']); ?>" required>
              <label class="labelInput" for="phone">Telefone</label>
            </div>
            <div class="item col-6">
              <label for="gender" class="labelSelect">Sexo</label>
              <select name="gender" id="gender" required>
                  <?php
                    $genders = ["F", "M", "N/I"];
                    foreach ($genders as $gender) {
                      $selected = $gender == $professional['gender'] ? 'selected' : '';
                      echo <<<HTML
                        <option value="{$gender}" {$selected}>{$gender}</option>
                      HTML;
                    }
                  ?>
              </select>
            </div>
            <div class="item col-6">
              <label for="birthday" class="labelSelect">Data de Nascimento</label>
              <input type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($data['birthday']); ?>" required>
            </div>
            <div class="item col-6">
              <label for="specialty" class="labelSelect">Especialidade</label>
              <select name="specialty" id="specialty" required>
                <option value="">Selecione</option>
                <?php
                  $sqlSpecialty = "SELECT * FROM Specialty ORDER BY id";
                  $resultSpecialty = $connectionDB->query($sqlSpecialty);

                  while($data = $resultSpecialty->fetch_assoc()){
                    $selected = $data['id'] == $professional['specialty_id'] ? 'selected' : '';
                    echo <<<HTML
                      <option value="{$data['id']}" $selected>{$data['specialty']}</option>
                    HTML;
                  }
                ?>
              </select>
            </div>
            <div class="item col-6">
              <label for="professional" class="labelSelect">Profissional</label>
              <select name="professional" id="professional" required>
                <?php 
                  // $sqlProfessional ="SELECT e.id, p.name FROM Person p 
                  //   INNER JOIN Employee e ON e.person_id = p.id
                  //   WHERE e.specialty_id = ?
                  //   ORDER BY e.id";

                  // $resultProfessional = $connectionDB->query($sqlProfessional);

                  // while($data = $resultProfessional->fetch_assoc()){
                  //   $selected = $data['e.specialty_id'] == $professional['specialty_id'] ? 'selected' : '';
                  //   echo <<<HTML
                  //     <option value="{$data['id']}" $selected>{$data['p.name']}</option>
                  //   HTML;
                  // }
                ?>
              </select>
            </div>
            <div class="item col-6">
              <label for="consultationDate" class="labelSelect">Data da Consulta</label>
              <input class="inputs" type="date" name="consultationDate" id="consultationDate" value="<?php echo htmlspecialchars($data['consultation_date']); ?>" required>
            </div>
            <div class="item col-6">
              <label for="consultationTime" class="labelSelect">Horário</label>
              <select name="consultationTime" id="consultationTime" value="<?php echo htmlspecialchars($data['consultation_time']); ?>" required>
                <option selected>Selecione</option>
                <option value="08:00">08:00</option>
                <option value="09:30">09:30</option>
                <option value="10:00">10:00</option>
                <option value="11:00">11:00</option>
                <option value="13:00">13:00</option>
                <option value="15:00">15:00</option>
              </select>
            </div>
          <?php 
            }
          ?>
        </div>
      </fieldset>
      <div class="btn">
        <a href="../../listing/listOfPatients.php">Cancelar</a>
        <button type="submit">Agendar</button>
      </div>
    </form>
  </main>
  <footer>
    <p>&copy By Layza Nauane</p>
  </footer>
  <script src="../../../js/scheduling.js"></script>
</body>
</html>

