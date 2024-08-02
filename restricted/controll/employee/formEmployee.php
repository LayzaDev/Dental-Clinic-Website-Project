<?php
  include("editEmployee.php");
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
    <form id="registrationForm" action="editEmployee.php?id=<?php echo $id; ?>" method="post">
      <fieldset>
        <legend>Atualizar Dados Do Funcionário</legend>
        <div class="wrapper">
          <?php 
            while ($data = $result->fetch_assoc()) {
          ?>
            <div class="item col-12">
              <input class="inputs" type="text" id="name" name="name" value="<?php echo htmlspecialchars($data['name']); ?>" required>
              <label class="labelInput" for="name">Nome</label>
            </div>
            <div class="item col-4">
              <input class="inputs" type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($data['cpf']); ?>" required>
              <label class="labelInput" for="cpf">CPF</label>
            </div> 
            <div class="item col-8">
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
            <div class="item item-special col-4">
              <input class="inputs" type="tel" id="phone" name="phone" pattern="[0-9]{2} [0-9]{5}-[0-9]{4}" maxlength="13" value="<?php echo htmlspecialchars($data['phone']); ?>" required>
              <label class="labelInput" for="phone">Telefone</label>
            </div>
            <div class="item col-4">
              <label for="birthday" class="labelSelect">Data de Nascimento</label>
              <input class="inputs" type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($data['birthday']); ?>">
            </div>
            <div class="item col-3">
              <label class="labelSelect" for="contract_start" >Início do Contrato</label>
              <input class="inputs" type="date" name="contract_start" id="contract_start" value="<?php echo htmlspecialchars($data['contract_start']); ?>" require>
            </div>
            <div class="item item-special col-3">
              <input class="inputs" type="text" id="cro" name="cro" value="<?php echo htmlspecialchars($data['cro']); ?>" required>
              <label class="labelInput" for="cro">CRO</label>
            </div>
            <div class="item item-special col-3">
              <input class="inputs" type="number" id="wage" name="wage" value="<?php echo htmlspecialchars($data['wage']); ?>">
              <label class="labelInput" for="wage">Salário</label>
            </div>
            <div class="item col-3">
              <label for="specialty" class="labelSelect">Especialidade</label>
              <select name="specialty" id="specialty" required>
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
            <div class="item col-4">
              <input class="inputs" type="text" id="cep" name="cep" pattern="[0-9]{5}-[0-9]{3}" value="<?php echo htmlspecialchars($data['cep']); ?>">
              <label class="labelInput" for="cep">CEP</label>
            </div>
            <div class="item col-8">
              <input class="inputs" type="text" id="street" name="street" value="<?php echo htmlspecialchars($data['street']); ?>">
              <label class="labelInput" for="street">Logradouro</label>
            </div>
            <div class="item col-4">
              <input class="inputs" type="number" id="number" name="number" pattern="[0-9]{5}-[0-9]{3}" value="<?php echo htmlspecialchars($data['number']); ?>">
              <label class="labelInput" for="number">Número</label>
            </div>
            <div class="item col-8">
              <input class="inputs" type="text" id="city" name="city" value="<?php echo htmlspecialchars($data['city']); ?>">
              <label class="labelInput" for="city">Cidade</label>
            </div>  
            <div class="item col-4">
              <label for="uf" class="labelSelect">Estado</label>
              <select name="uf" id="uf" class="form-select" >
                <?php
                  $ufs = ["AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO"];
                  foreach ($ufs as $uf) {
                    $selected = $uf == $data['uf'] ? 'selected' : '';
                    echo <<<HTML
                      <option value="{$uf}" {$selected}>{$uf}</option>
                    HTML;
                  }
                ?>
              </select>
            </div>
            <div class="item item-special col-8">
              <input class="inputs" type="text" id="neighborhood" name="neighborhood" value="<?php echo htmlspecialchars($data['neighborhood']); ?>">
              <label class="labelInput" for="neighborhood">Bairro</label>
            </div>
          <?php
            }
          ?>
        </div>
      </fieldset>
      <div class="btn">
        <a href="../../listing/listOfEmployees.php">Cancelar</a>
        <button type="submit" id="btnRegister">Atualizar</button>
      </div>
    </form>
  </main>
  <script src="../../../js/ajax.js"></script>
</body>
</html>
