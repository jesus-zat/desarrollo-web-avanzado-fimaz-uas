<?php
//Jesús Zatarain Tirado LISI 3-1    
    require_once("../models/modeloProductos.php");

    class productosController{

        private $model;

        public function __construct()
        {
            $this->model = new productosModel();
        }
        //Creamos método controlador que mandará llamar la función insert del Modelo.
        //También mandará los parámetros necesarios para guardar en la tabla "productos".
        //Si los datos se guardan redireccionará al usuario a la pantalla de inicio de lo
        //contrario se mantendrá en la pantalla del formulario de captura de datos del torneo.
        public function saveProducto($producto, $cantidad, $precio_unitario){
            //Recordemos que la función insert del modelo, regresa el último id generado.
            $id= $this->model->insert($producto, $cantidad, $precio_unitario);
            return ($id!=false) ? header("Location: ../index.php") : header("Location: fromProductos.php");
        }
    }
?>