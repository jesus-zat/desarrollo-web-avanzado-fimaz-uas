<?php
//Jesús Zatarain Tirado LISI 3-1

namespace Models;

use Config\Database;
use PDO;
use PDOException;

/**
 * Modelo de Auditoría y Bitácora (BitacoraModel)
 *
 * Clase encargada de interactuar directamente con la tabla de bitácora en la
 * base de datos. Permite registrar las acciones de los usuarios y extraer el
 * historial completo para su posterior auditoría.
 */
class BitacoraModel {
    /**
     * @var \PDO Instancia de la conexión a la base de datos.
     */
    private PDO $db;

    /**
     * Inicializa el modelo estableciendo la conexión con el servidor de datos.
     */
    public function __construct()
    {
        $conexion = new Database();
        $this->db = $conexion->connect();
    }

    /**
     * Registra una nueva acción en la bitácora del sistema.
     *
     * Prepara e inserta los datos del usuario y el evento correspondiente. En caso
     * de que la base de datos experimente una falla catastrófica, captura la excepción
     * y genera de forma automática un respaldo físico en un archivo de log local.
     *
     * @param mixed $usuario Nombre de usuario o identificador de quien realiza la acción.
     * @param mixed $accion Descripción detallada de la operación ejecutada.
     * @return bool Retorna verdadero si se guardó en la base de datos; falso si ocurrió un error.
     */
    public function log($usuario, $accion) {
        try{
            $sql = "INSERT INTO bitacora (usuario, accion) VALUES (:usuario, :accion)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":usuario", $usuario);
            $stmt->bindParam(":accion", $accion);
            return $stmt->execute();
        } catch (PDOException $e){
            $fecha = date("Y-m-d H:i:s");
            $mensaje = "[$fecha] ERROR DB: " . $e->getMessage() . " | Intentó: $usuario -> $accion" . PHP_EOL;
            
            $rutaLog = BASE_PATH . "/logs/errores_criticos.log";
            
            file_put_contents($rutaLog, $mensaje, FILE_APPEND);
            
            return false;
        }
    }

    /**
     * Obtiene el historial completo de eventos registrados.
     *
     * Ejecuta una consulta directa para extraer las columnas de identificación,
     * usuario, acción y la marca de tiempo de la tabla de bitácora.
     *
     * @return array Conjunto de registros indexados en forma de arreglo asociativo.
     */
    public function listarTodos(){
        $sql = "SELECT id, usuario, accion, fecha FROM bitacora";
        $query = $this->db->query($sql);
        return $query->fetchAll();
    }
}