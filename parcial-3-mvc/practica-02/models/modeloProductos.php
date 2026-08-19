<?php

//Jesús Zatarain Tirado LISI 3-1

require_once("../config/DataBase.php");

class productosModel
{
    public $PDO;

    public function __construct()
    {
        //Declaramos la variable para conexión a la BD.
        //Instanciamos la clase DataBase.
        $conexion = new DataBase();

        //Llamamos al método connect y lo asignamos a nuestra
        //variable $PDO.
        $this->PDO = $conexion->connect();
    }

    //Método para hacer un INSERT en la BD, en tabla "productos".
    public function insert($producto, $cantidad, $precio_unitario)
    {
        //Iniciamos declarando el statement y preparando la consulta.
        $statement = $this->PDO->prepare("INSERT INTO productos VALUES(null, :producto, :cantidad, :precio_unitario)");

        //Asociamos los valores colocados como placeholder en el query mediante el bindParam().
        $statement->bindParam(":producto", $producto);
        $statement->bindParam(":cantidad", $cantidad);
        $statement->bindParam(":precio_unitario", $precio_unitario);

        //Ejecutamos el statement mediante execute().
        //Valoraremos mediante un shorthand if lo que regresará este método.
        return ($statement->execute()) ? $this->PDO->lastInsertId() : false;
    }

    //Crearemos el método para listar todos los productos.
    public function read(){
        $statement = $this->PDO->prepare("SELECT * FROM productos");
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }
}
?>