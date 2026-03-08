<?php
//No es necesario incluir la clase de Usuario ya que admin la esta heredando
require "Admin.php";

//Instanciamos la clase
$objAdmin = new Admin("Jesús Zatarain Tirado", "jesusitojzt@gmail.com");

//mostramos datos heredados de Usuario
echo "Nombre: " .$objAdmin->getNombre() . "<br>";
echo "correo: " .$objAdmin->getCorreo() . "<br>";

//Mostramos el dato de admin
echo "Rol: " .$objAdmin->getRol();
?>