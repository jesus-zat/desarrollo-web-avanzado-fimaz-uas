<?php
//extendemos clase Usuario para que alumno tambien herede de usuario
require_once "Usuario.php";

class Alumno extends Usuario{
    private $matricula;

    public function __construct($nombre,$correo,$matricula){

    //usamos constructor de Usuario
    parent::__construct($nombre,$correo);

    $this->matricula = $matricula;
    }

    public function getMatricula(){
        return $this->matricula;
    }
    
    public function getRol(){
        return "Alumno";
    }
}
?>