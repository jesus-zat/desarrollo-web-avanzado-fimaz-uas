<?php

    //Jesús Zatarain Tirado LISI 3-1

    require_once("../../models/torneosModel.php");

    class torneosController{
        private $modelo;

        public function __construct()
        {
            $this->modelo = new torneosModel();
        }


        //Creamos método controlador que mandará a llamar
        //la función insert del modelo
        //Si los datos se guardan redireccionaremos a ese usuario a la
        //pantalla princial de inicio, de lo contrario
        //se mantendrá en la pantalla del formulario de captura
        //de datos del torneo

        public function saveTorneo($nombreTorneo, $organizador, $patrocinadores,
        $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio, $usuario, $contrasena){
            //Recordemos que la función insert del modelo, regresa
            //el último id generado
            $id = $this->modelo->insert($nombreTorneo, $organizador,
            $patrocinadores, $sede, $categoria, $premio1, 
            $premio2, $premio3, $otroPremio, $usuario, $contrasena);
            return ($id != false) ? header("Location: admin.php") : header("Location: frmTorneos.php");
        }

        //Método que manda a ejecutar la función read del modelo del torneo.
        public function readTorneo(){
            return ($this->modelo->read()) ? $this->modelo->read() : false;
        }

        //Método para ejecutar la función readOne del modelo torneo
        public function readOneTorneo($id){
            return ($this->modelo->readOne($id) != false) ? $this->modelo->readOne($id) 
            : header("Location: admin.php");
        }

        //Método que manda llamar la función update del modelo
        public function updateTorneo($id, $nombreTorneo, $organizador, $patrocinadores,
        $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio){

            return ($this->modelo->update($id, $nombreTorneo, $organizador, $patrocinadores,
            $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio)) != false ? 
            header("Location: readOneTorneo.php?id=".$id) 
            : header("Location: readAll.php") ;
        }

        //Método que mande a llamar a la función delete del modelo
        public function delete($id){
            return ($this->modelo->delete($id)) ? header("Location: readAllTorneos.php") 
            : header("Location: readOneTorneo.php?id=.$id");
        }
    }
?>