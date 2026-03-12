<?php
//Extendemos clase Usuario para que Admin herede de esta 
require_once "Usuario.php";

class Admin extends Usuario {
    public function getRol(){
        return "Administrador";
    }
}
?>