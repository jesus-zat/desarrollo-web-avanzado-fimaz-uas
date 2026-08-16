<?php

//Jesús Zatarain Tirado LISI 3-1

    require_once("../../config/DataBase.php");

    class torneosModel{
        public $PDO;

        public function __construct()
        {
            //Declaramos la variable para la conexión a la BD
            //Instanciamos la clase Database
            $connection = new DataBase();
            //Llamamos al método connect y lo asignamos a nuestra
            //variable local $PDO
            $this->PDO= $connection->connect();
        }

        //Método para hacer un INSERT en la BD, en la tabla "torneos"
        public function insert($nombreTorneo, $organizador, $patrocinadores,
        $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio, $usuario, $contrasena){
            //Encriptar contraseña asignada al organizador del torneo 
            $contrasena = $this->passwordEncrypt($contrasena);
            //Iniciamos declarando el statement y preparando la consulta
            $statement = $this->PDO->prepare(
                "INSERT INTO torneos (id, nombreTorneo,
                organizador, patrocinadores, sede, categoria,
                premio1, premio2, premio3, otroPremio, usuario, contrasena)
                VALUES (null, :nombreTorneo,
                :organizador, :patrocinadores, :sede, :categoria,
                :premio1, :premio2, :premio3, :otroPremio, :usuario, :contrasena)"
            );
            $statement->bindParam(":nombreTorneo",$nombreTorneo);
            $statement->bindParam(":organizador",$organizador);
            $statement->bindParam(":patrocinadores",$patrocinadores);
            $statement->bindParam(":sede",$sede);
            $statement->bindParam(":categoria",$categoria);
            $statement->bindParam(":premio1",$premio1);
            $statement->bindParam(":premio2",$premio2);
            $statement->bindParam(":premio3",$premio3);
            $statement->bindParam(":otroPremio",$otroPremio);
            $statement->bindParam(":usuario",$usuario);
            $statement->bindParam(":contrasena",$contrasena);

            //Ejecutamos el statement mediante execute().
            //Valoraremos mediante un shorthand if lo que este
            //método insert regresará.
            return ($statement->execute()) ? $this->PDO->lastInsertId(): false;
        }

        //El administrador creará el torneo y al usuario (organizador).
        //Por lo que al crear su password, buscaremos enctriparla por seguridad
        //Utilizaremos el método password_hash y password_verify.
        public function passwordEncrypt($password){
            $passwordEncrypted = password_hash($password, PASSWORD_DEFAULT);
            return $passwordEncrypted;
        }

        public function passwordDencrypted($passwordEncrypted, $passwordCandidate){
            //con un shorthand if, verificamos el password candidato.
            return (password_verify($passwordCandidate, $passwordEncrypted)) ? true:false;
        }

        //Crearemos el método para listar todos los torneos.
        public function read(){
            $statement = $this->PDO->prepare(
                "SELECT * FROM torneos;"
            );
            return ($statement->execute()) ? $statement->fetchAll() : false;
        }

        //Método para devolver la información de un torneo
        public function readOne($id){
            $statement = $this->PDO->prepare(
                "SELECT * FROM TORNEOS
                WHERE id = :id LIMIT 1"
            );
            $statement->bindParam(":id",$id);
            return ($statement->execute()) ? $statement->fetch() : false;
        }

        //Método para actualizar los datos del torneo
        public function update($id, $nombreTorneo, $organizador, $patrocinadores,
        $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio){
            $statement = $this->PDO->prepare(
                "UPDATE torneos SET nombreTorneo = :nombreTorneo,
                organizador= :organizador, patrocinadores = :patrocinadores, 
                sede = :sede, categoria = :categoria, premio1 = :premio1, 
                premio2 = :premio2, premio3 = :premio3, otroPremio = :otroPremio
                WHERE id = :id"
            );

            //Asociamos los valores colocados como placeholder en
            //el query mediante bindParam().
            $statement->bindParam(":id",$id);
            $statement->bindParam(":nombreTorneo",$nombreTorneo);
            $statement->bindParam(":organizador",$organizador);
            $statement->bindParam(":patrocinadores",$patrocinadores);
            $statement->bindParam(":sede",$sede);
            $statement->bindParam(":categoria",$categoria);
            $statement->bindParam(":premio1",$premio1);
            $statement->bindParam(":premio2",$premio2);
            $statement->bindParam(":premio3",$premio3);
            $statement->bindParam(":otroPremio",$otroPremio);

            //Ejecutamos el statement mediante execute().
            //Valoraremos mediante un shorthand if lo que este
            //método insert regresará.
            return ($statement->execute()) ? $id : false;
        }

        //Método para eliminar un torneo
        public function delete($id){
            $statement = $this->PDO->prepare(
                "DELETE FROM TORNEOS
                WHERE id = :id"
            );
            $statement->bindParam(":id",$id);
            return ($statement->execute()) ? true : false;
        }
    }

?>