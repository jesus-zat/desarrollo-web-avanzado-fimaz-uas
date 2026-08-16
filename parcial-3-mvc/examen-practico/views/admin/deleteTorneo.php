<?php

    //Jesús Zatarain Tirado LISI 3-1
    
    require_once("../../controllers/torneosController.php");

    $objController = new torneosController();

    //Obtener el ID desde el botón que mandará eliminar el registro
    //Lo obtendremos de la pantalla del listado general de torneos

    $objController->delete($_GET['id']);
?>