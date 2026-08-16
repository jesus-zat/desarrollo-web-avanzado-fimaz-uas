<?php

try{

    $pdo = new PDO(
        "mysql:host=localhost;dbname=proyecto;charset=utf8mb4",
        "demo",
        "123"
    );

    echo "Conexión exitosa";

}catch(PDOException $e){

    echo $e->getMessage();
}