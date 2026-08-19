<?php
//Jesús Zatarain Tirado LISI 3-1

namespace Models;

use Config\Database;
use PDO;
use PDOException;

/**
 * Modelo de Gestión de Usuarios (UsuarioModel)
 *
 * Clase encargada de interactuar directamente con la tabla de usuarios en la
 * base de datos. Provee los métodos de consulta esenciales para los procesos
 * de autenticación, control de accesos y verificación de credenciales del sistema.
 */
class UsuarioModel{
    /**
     * @var \PDO Instancia de conexión activa a la base de datos.
     */
    private PDO $conexion;

    /**
     * Inicializa el modelo y establece la conexión PDO con el servidor de datos.
     */
    public function __construct()
    {
        $db = new Database();
        $this->conexion = $db->connect();
    }

    /**
     * Busca un registro de usuario en la base de datos mediante su "username".
     *
     * Método fundamental para el proceso de inicio de sesión (Login). Ejecuta una
     * consulta preparada limitando el resultado a una sola coincidencia y vincula
     * el parámetro de forma segura para prevenir ataques de inyección SQL.
     *
     * @param string $username Nombre de usuario único que se desea consultar.
     * @return array|null Estructura de datos del usuario en un arreglo asociativo si se encuentra, o null si no existe o falla la consulta.
     */
    public function buscarPorUsername(string $username): ?array{
        try{
            $sql = 'SELECT * FROM usuarios WHERE username = :username LIMIT 1;';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':username',$username);
            $stmt->execute();
            $usuario = $stmt->fetch();
            return $usuario ?: null;
        } catch (PDOException $e){
            return null;
        }
    }
}
?>