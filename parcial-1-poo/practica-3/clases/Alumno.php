<?php
// Incluye Usuario solo una vez para herencia segura
require_once "Usuario.php"; 

class Alumno extends Usuario {
    private $matricula;

    /*Constructor para inicializar nombre, correo y matrícula
      Se usa parent::__ Cuando queramos acceder a una constante o metodo de
      una clase padre, la palabra reservada parent nos sirve para llamarla 
      desde una clase extendida.
    */
    public function __construct($nombre, $correo, $matricula) {
        parent::__construct($nombre, $correo); // Llama al constructor de Usuario
        $this->matricula = $matricula;
    }

    // Setter y getter de matrícula
    public function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    // Devuelve el rol Alumno
    public function getRol() {
        return "Alumno";
    }
}
?>