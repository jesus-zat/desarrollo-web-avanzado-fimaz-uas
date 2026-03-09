<?php

// Importamos la clase Usuario para usar herencia
require_once "Usuario.php";

class Admin extends Usuario {

    // Retorna el rol del usuario
    public function getRol(){
        return "Administrador";
    }

}
?>