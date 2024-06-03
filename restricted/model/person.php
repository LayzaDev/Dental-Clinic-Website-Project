<?php
  class Person {
    public $username;
    public $cpf;
    public $sex;
    public $email;
    public $phone;
    public $birthday;

    function __construct($username, $cpf, $sex, $email, $phone, $birthday){
      $this->username  = $username;
      $this->cpf  = $cpf;
      $this->sex  = $sex;
      $this->email  = $email;
      $this->phone  = $phone;
      $this->birthday  = $birthday;
    } 

    public function AddToDataBase($pdo) {
      try {
        $sql = <<<SQL
          INSERT INTO Person (username, cpf, sex, email, phone, birthday)
          VALUES (?, ?, ?, ?, ?, ?)
        SQL;

        $stmt = $pdo->prepare($sql);
        if(!$stmt->execute([
          $this->$username, 
          $this->$cpf, 
          $this->$sex, 
          $this->$email, 
          $this->$phone, 
          $this->$birthday
        ])) throw new Exception("Falha na inserção em Person");
      } catch (Exception $e) {
        exit('Falha em AddToDataBase de person.php' . $e->getMessage());
      }
    }

    public function GetPersons($pdo) {
      try {
        $sql = <<<SQL
          SELECT * FROM Person
          ORDER BY username
        SQL;

        $response = $pdo->query($sql);

        $arrayPersons = [];

        while($row = $response->fetch()){

          $username = htmlspecialchars($row['username']);
          $cpf = htmlspecialchars($row['cpf']);
          $sex = htmlspecialchars($row['sex']);
          $email = htmlspecialchars($row['email']);
          $phone = htmlspecialchars($row['phone']);
          $birthday = htmlspecialchars($row['$birthday']);

          $newPerson = new Person (
            $username,
            $cpf,
            $sex,
            $email,
            $phone,
            $birthday
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
          DELETE FROM PERSON
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