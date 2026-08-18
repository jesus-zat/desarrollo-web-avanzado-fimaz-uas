<?php
//Jesús Zatarain Tirado LISI 3-1
    require_once("../controllers/controladorProductos.php");
    $producto = $_POST['txtProducto'];
    $cantidad = $_POST['txtCantidad'];
    $precio = $_POST['txtPrecio'];
    //Instanciamos nuestro Controlador.
    $objController = new productosController();
    $objController->saveProducto($producto, $cantidad, $precio);
?>