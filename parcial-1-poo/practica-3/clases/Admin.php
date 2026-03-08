<?php
//incluimos la clase usuario para heredar sus propiedades
/*Utilizamos reuire_once para asegurarnos que la clase Usuario
esta disponinble y evitar errores en dado caso que se haya
incluido antes, ya que Admin hereda de ella 
*/
require_once "Usuario.php";

class Admin extends Usuario {
    //Metodo original de Admin
    public function getRol(){
        return "Administrador"
    }

}
?>