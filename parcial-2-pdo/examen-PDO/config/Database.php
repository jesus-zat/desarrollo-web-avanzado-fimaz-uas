<!-- Jesús Zatarain Tirado  3-1 -->
<?php
    class Database{
        private $host = "localhost:3307";
        private $db = "phppdobd";
        private $user = "root";
        private $password = "";
        private $connection;

        public function __construct(){
            try{
                $dns = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
                
                $this->connection = new PDO($dns, $this->user, $this->password);

                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die ("Error de conexión: " . $e->getMessage());
            }
        }

        public function getConnection(){
            return $this->connection;
        }
    }
?>