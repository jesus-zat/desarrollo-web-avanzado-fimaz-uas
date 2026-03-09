<?php

// Clase base que define los atributos comunes de todos los usuarios
class Usuario {

    protected $nombre;
    protected $correo;

    // Constructor con validación de correo
    public function __construct($nombre, $correo) {

        // Verifica que el correo tenga formato válido
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Correo inválido: $correo");
        }

        $this->nombre = $nombre;
        $this->correo = $correo;
    }

    // Getters
    public function getNombre(){
        return $this->nombre;
    }

    public function getCorreo(){
        return $this->correo;
    }

}
?>