<?php
class Usuario {
    
    protected $nombre;
    protected $correo;

    //constructor y validacion 
    public function __construct($nombre, $correo){
        if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
            //si no es valido lanzamos la excepcion 
            throw new Exception("Correo invalido: $correo");
        }
        $this->nombre = $nombre;
        $this->correo = $correo;
    }

    //Getters para nombre y correo 

    public function getNombre(){
        return $this->nombre;
    }

    public function getCorreo(){
        return $this->correo;
    }

}
?>