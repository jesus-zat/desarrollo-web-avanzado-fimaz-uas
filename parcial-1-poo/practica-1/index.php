<?php 
/*Utilizamos require porque es necesario el archivo para su ejecución
(No tendria sentido usar el index sin este archivo) 
*/
require "Usuario.php";

/*Intanciamos la clase, al crear el objeto se ejecuta el constructor y asignamos
 los valores inciales de nombre y correo
*/
$objUsuario = new Usuario("Jesús Zatarain Tirado", "jesusitojztgmail.com");

//Mostramos el nombre y correo utilizando el metodo getter
echo "Nombre: " .$objUsuario->getNombre();
echo "<br>";
echo "Correo: " .$objUsuario->getCorreo();
?>