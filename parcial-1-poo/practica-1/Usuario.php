<?php 
Class Usuario {
    //declaramos atributos privados
    private $nombre;
    private $correo;

    //constructor de la clase
    public function __construct($nombre, $correo)
    {
        $this->nombre = $nombre;
        $this->correo = $correo;
    }

    //metodos getters

    public function getNombre() {
        return $this->nombre;

    }

    public function getCorreo() {
        return $this->correo;
    }

    //metodos setters

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
  
    public function setCorreo($correo) {
        $this->correo = $correo;
    }

}
?>

