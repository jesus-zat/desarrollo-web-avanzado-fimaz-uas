<?php
class Usuario {
private $nombre;
private $correo;

public function __construct($nombre, $correo) {
    $this->nombre = $nombre;
    //utilizamos setter para validar el correo
    $this->setCorreo($correo);
}

//Getters de nombre y correo
public function getNombre() {
    return $this->nombre;
}

public function getCorreo(){
    return $this->correo;
}

//Setter de nombre
public function setNombre($nombre){
    $this->nombre = $nombre;
}

//setter de correo con validacion 
public function setCorreo($correo){
    $this->validarCorreo($correo);
    $this->correo = $correo;
}

//Metodo que valida el correo

public function validarCorreo($correo) {
    //comprobamos si el correo tiene un formato valido
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        /*Si el correo no es valido, lanzamos una excepcion, esto detiene
         la ejecucion del programa y permite manejar el error con try/catch
        */
        throw new Exception("Correo invalido: $correo");
        }
        //Si el correo es valido, no hace nada y se ejecuta normalmente
    }
}
?>