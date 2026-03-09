<?php

// Importamos la clase Usuario
require_once "Usuario.php";

class Invitado extends Usuario {

    private $empresa;

    public function __construct($nombre,$correo,$empresa){

        parent::__construct($nombre,$correo);
        $this->empresa = $empresa;
    }

    public function getEmpresa(){
        return $this->empresa;
    }

    // Rol del usuario
    public function getRol(){
        return "Invitado";
    }

}
?>