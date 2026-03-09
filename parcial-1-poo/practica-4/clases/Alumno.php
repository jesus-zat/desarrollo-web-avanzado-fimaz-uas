<?php

// Importamos Usuario para heredar sus propiedades
require_once "Usuario.php";

class Alumno extends Usuario {

    private $matricula;

    // Constructor reutilizando el del padre
    public function __construct($nombre,$correo,$matricula){

        parent::__construct($nombre,$correo);
        $this->matricula = $matricula;
    }

    public function getMatricula(){
        return $this->matricula;
    }

    // Rol del usuario
    public function getRol(){
        return "Alumno";
    }

}
?>