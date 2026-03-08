<?php 
//Incluimos la clase Usuario para poder heredarlo
require "Usuario.php";
/*Definimos clase Admin y agregamos extends para que Admin herede 
  todo lo que puede hacer usuario
    */
class Admin extends Usuario {
/* getRol devuelve un valor en este caso Administrador, de igual manera
   este tambien puede usarse dentro del programa y tambien puedes mostrarlo,
   compararlo o usar operadores con el
*/
public function getRol() {
    return "Administrador";
}

}
?>