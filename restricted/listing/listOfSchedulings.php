<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restrita</title>

  <!-- 2: Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

  <style>
    body {
      padding-top: 2rem;
    }

    img {
      width: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h3>Meus Agendamentos</h3> 
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <tr>
          <th class="dt-center">Id</th>
          <th class="dt-center">Paciente</th>
          <th class="dt-center">Data da Consulta</th>
          <th class="dt-center">Horario da Consulta</th>
          <th class="dt-center">Serviço</th>
          <th class="dt-center">Profissional</th>
        </tr>
        <?php
          foreach($arrayScheduling as $scheduling){
            echo <<<HTML
              <tr>
                <td><a href="controller.php?acao=deleteScheduling&cpf=$scheduling->id">Excluir</a></td>
                <td>$Patient->id</td>
                <td>$Patient->username</td>
                <td>$Patient->cpf</td>
                <td>$Patient->sex</td>
                <td>$Patient->email</td>
                <td>$Patient->phone</td>
                <td>$Patient->birthday</td>
              </tr>
            HTML;
          }
        ?>
      </table>
    </div>
  </div>
</body>
</html>