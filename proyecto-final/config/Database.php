<?php
//Jesús Zatarain Tirado LISI 3-1

namespace Config;

use PDO;
use PDOException;

/**
 * Clase para manejar la conexión con la base de datos.
 *
 * Contiene los datos necesarios para conectarse a MySQL
 * y establece la conexión utilizando PDO.
 */
class Database
{
    /**
     * Dirección del servidor donde se encuentra la base de datos.
     */
    private string $host = "localhost";

    /**
     * Nombre de la base de datos que utilizará el sistema.
     */
    private string $dbname = "tienda_mvc";

    /**
     * Usuario utilizado para conectarse a MySQL.
     */
    private string $username = "root";

    /**
     * Contraseña del usuario de MySQL.
     */
    private string $password = "";

    /**
     * Codificación utilizada para manejar los datos.
     */
    private string $charset = "utf8mb4";

    /**
     * Crea y devuelve una conexión con la base de datos.
     *
     * Configura la conexión PDO y establece las opciones
     * necesarias para manejar errores y obtener los resultados.
     *
     * @return PDO Conexión configurada con la base de datos.
     */
    public function connect(): PDO
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

            $pdo = new PDO($dsn, $this->username, $this->password);

            // Configura PDO para mostrar los errores mediante excepciones.
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Hace que los resultados de las consultas sean arreglos asociativos.
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $pdo;

        } catch (PDOException $e) {

            // Muestra el mensaje cuando ocurre un error de conexión.
            die('Error de conexión: ' . $e->getMessage());
        }
    }
}

?>