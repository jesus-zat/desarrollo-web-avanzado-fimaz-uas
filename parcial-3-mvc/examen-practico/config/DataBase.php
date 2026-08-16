<?php
    //Jesus Zatarain Tirado LISI 3-1
    //Crear una clase para conexion a base de datos mediante PDO.

    class DataBase{
        //Atributos de la clase DataBase
        private $host="localhost";
        private $db="proyecto";
        private $user="demo";
        private $password = "123";

        public function __construct()
        {
            //Constructor...

        }

        //Metodo para conexion a la base de datos.
        public function connect(){
            try {
                $PDO = new PDO("mysql:host=".$this->host.
                ";dbname=".$this->db,$this->user,$this->password);
                 return $PDO;

            } catch (PDOException $E) {
                 return $e->getMessage();  

            }
        }

    }
?>