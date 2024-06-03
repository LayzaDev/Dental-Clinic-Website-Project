<?php
  class Employee  extends Person {

    // Dados de Funcionario
    public $hiringDate;
    public $wage;
    public $cro;
    public $specialty;
    public $personId;

    function __construct($hiringDate, $wage, $cro, $specialty, $personId){
      $this->hiringDate  = $hiringDate;
      $this->wage  = $wage;
      $this->cro  = $cro;
      $this->specialty  = $specialty;
      $this->personId = $personId;
    } 

    public function AddToDataBase($pdo) {
      try {
        $sql = <<<SQL
          INSERT INTO Employee (hiringDate, wage, cro, specialty, personId)
          VALUES (?, ?, ?, ?, ?)
        SQL;

        $stmt = $pdo->prepare($sql);
        if(!$stmt->execute([
          $this->$hiringDate, 
          $this->$wage, 
          $this->$cro, 
          $this->$specialty, 
          $this->$personId
        ])) throw new Exception("Falha na inserção em Employee");
      } catch (Exception $e) {
        exit('Falha em AddToDataBase de employee.php' . $e->getMessage());
      }
    }

    public function GetEmployee($pdo) {
      try {
        $sql = <<<SQL
          SELECT * FROM Employee
        SQL;

        $response = $pdo->query($sql);

        $arrayEmployees = [];

        while($row = $stmt->fetch()){

          $hiringDate = htmlspecialchars($row['hiringDate']);
          $wage = htmlspecialchars($row['wage']);
          $cro = htmlspecialchars($row['cro']);
          $specialty = htmlspecialchars($row['specialty']);
          $personId = htmlspecialchars($row['personId']);

          $newPerson = new Person (
            $hiringDate,
            $wage,
            $cro,
            $specialty,
            $personId
          );

          $arrayPersons[] = $newPerson;
        }
        return $arrayPersons;
      } catch (Exception $e) {
        exit('Falha em GetPersons de person.php' . $e->getMessage());
      }
    }

    public function removeByCPF($pdo) {
      try {
        $sql = <<<SQL
          DELETE FROM Employee
          WHERE cpf = ?
          LIMIT 1
        SQL;

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cpf]);

      } catch (Exception $e) {
        exit('Falha em removeByCPF de person.php' . $e->getMessage());
      }
    }
  }
?>