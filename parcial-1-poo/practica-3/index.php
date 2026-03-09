<?php

require_once "clases/Alumno.php";
require_once "clases/Admin.php";

// Alumno con datos completos al instanciar
try {
    $objAlumno = new Alumno("Jesús", "jesusitojzt@gmail.com", "21759");
    echo $objAlumno->getNombre() . "<br>";
    echo $objAlumno->getCorreo() . "<br>";
    echo $objAlumno->getRol() . "<br>";
    echo $objAlumno->getMatricula() . "<br>";
} catch (Exception $e) {
    echo "Error Alumno: " . $e->getMessage() . "<br>";
}

// Admin con datos completos al instanciar
try {
    $objAdmin = new Admin("Pedro", "correo_invalido");
    echo $objAdmin->getNombre() . "<br>";
    echo $objAdmin->getCorreo() . "<br>";
    echo $objAdmin->getRol() . "<br>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

?>