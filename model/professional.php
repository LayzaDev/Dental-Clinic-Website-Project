<?php
  class Professional {
    public $idProfessional;
    public $username;
    public $specialty;

    function __construct($name, $specialty){
      $this->username = $name;
      $this->specialty = $specialty;
    }

    static function getSpecialtyProfessional(){
      try {
        
      } catch (Exception $e) {
        exit("Falha ao buscar os profissionais: " . $e->getMessage());
      }
    }
  }
?>