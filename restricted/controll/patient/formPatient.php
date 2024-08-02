<?php
  include_once("../../../database/conexaoMySQL.php");

  $connectionDB = mysqlConnect();

  $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

  if($id == 0) {
    die ("ID inválido");
  }

  $sql = <<<SQL
    SELECT 
      p.id, 
      p.name, 
      p.cpf, 
      p.gender, 
      p.phone, 
      p.birthday, 
      l.email,
      pt.employee_id,
      p.status
    FROM Person p
    JOIN Login l ON l.id = p.login_id
    JOIN Patient pt ON pt.person_id = p.id
    WHERE p.id = ?
    LIMIT 1
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
    <title>Restrita</title>

    <!-- Links CSS -->
    <link rel="stylesheet" href="../../css/register.css"> 
</head>
<body>
  <header>
    <img src="../../../image/logotipo.jpeg" alt="logo">
  </header>
  <hr>
  <main>  
    <form id="registrationForm" action="editPatient.php?id=<?php echo $id; ?>" method="post">
      <fieldset>
        <legend>Atualizar Dados Do Paciente</legend>
        <div class="wrapper">
          <div class="item col-8">
            <input class="inputs" type="text" id="name" name="name" value="<?php echo htmlspecialchars($data['name']); ?>" required>
            <label class="labelInput" for="name">Nome</label>
          </div>
          <div class="item col-4">
            <input class="inputs" type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($data['cpf']); ?>" required>
            <label class="labelInput" for="cpf">CPF</label>
          </div> 
          <div class="item item-special col-8">
            <input class="inputs" type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required>
            <label class="labelInput" for="email">E-mail</label>
          </div>
          <div class="item col-4">
            <label for="gender" class="labelSelect">Sexo</label>
            <select name="gender" id="gender" required>
              <?php
                $genders = ["F", "M", "N/I"];
                foreach ($genders as $gender) {
                  $selected = $gender == $data['gender'] ? 'selected' : '';
                  echo <<<HTML
                    <option value="{$gender}" {$selected}>{$gender}</option>
                  HTML;
                }
              ?>
            </select>
          </div>
          <div class="item item-special col-6">
            <input class="inputs" type="tel" id="phone" name="phone" pattern="[0-9]{2} [0-9]{5}-[0-9]{4}" maxlength="13" value="<?php echo htmlspecialchars($data['phone']); ?>" required>
            <label class="labelInput" for="phone">Telefone</label>
          </div>
          <div class="item col-6">
            <label for="birthday" class="labelSelect">Data de Nascimento</label>
            <input class="inputs" type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($data['birthday']); ?>">
          </div>
          <div class="item col-6">
            <label for="specialty" class="labelSelect">Especialidade</label>
            <select name="specialty" id="specialty">
              <option selected>Selecione</option>
              <?php
                $sqlSpecialty = "SELECT * FROM Specialty ORDER BY id";
                $resultSpecialty = $connectionDB->query($sqlSpecialty);

                while($row = $resultSpecialty->fetch_assoc()){
                  $selected = $row['id'] == $data['employee_id'] ? 'selected' : '';
                  echo <<<HTML
                    <option value="{$row['id']}" $selected>{$row['specialty']}</option>
                  HTML;
                }
              ?>
            </select>
          </div>
          <div class="item col-6">
            <label for="professional" class="labelSelect">Profissional</label>
            <select name="professional" id="professional">
            <!-- opções -->
            </select>
          </div>
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
