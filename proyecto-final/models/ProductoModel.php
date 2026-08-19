<?php
//Jesúa Zatarain Tirado LISI 3-1

namespace Models;

use Config\Database;
use PDO;
use PDOException;

/**
 * Modelo de Gestión de Productos (ProductoModel)
 *
 * Encargado de interactuar de forma directa con la tabla de productos en la base de datos.
 * Implementa consultas optimizadas para catálogos públicos, búsquedas con filtros,
 * paginación, control de unicidad de SKU y aislamiento transaccional seguro para operaciones de escritura.
 */
class ProductoModel{
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
     * Obtiene la lista completa de productos ordenados por ID de forma descendente.
     *
     * @return array Listado asociativo de todos los productos registrados o un arreglo vacío si ocurre un fallo.
     */
    public function obtenerTodos(): array{
        try{
            $sql='SELECT * FROM productos ORDER BY id DESC';
            $stmt = $this->conexion->query($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e){
            return [];
        }
    }

    /**
     * Realiza una búsqueda de productos filtrando por nombre o descripción.
     *
     * Si el parámetro de búsqueda se encuentra vacío, invoca automáticamente 
     * el método para listar el catálogo completo.
     *
     * @param string $termino Palabra o frase clave para filtrar los productos (opcional).
     * @return array Conjunto de registros que coinciden con los criterios de búsqueda.
     */
    public function buscarPublico(string $termino = ''): array{
        try{
            if (trim($termino) === ''){
                return $this->obtenerTodos();
            }

            $sql = 'SELECT * FROM productos 
            WHERE nombre LIKE :termino
            OR descripcion LIKE :termino
            ORDER BY id DESC';

            $stmt = $this->conexion->prepare($sql);
            $busqueda = '%'.$termino.'%';
            $stmt->bindParam(':termino',$busqueda);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e){
            return [];
        }
    }

    /**
     * Recupera la información de un producto específico mediante su ID.
     *
     * @param int $id Identificador numérico único del producto.
     * @return array|null Estructura de datos del producto si existe, o null en caso de no encontrarse.
     */
    public function obtenerPorId(int $id): ?array{
        try{
            $sql = 'SELECT * FROM productos WHERE id = :id LIMIT 1';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id',$id, PDO::PARAM_INT);
            $stmt->execute();
            $producto = $stmt->fetch();
            return $producto ?: null;
        } catch (PDOException $e){
            return null;
        }
    }

    /**
     * Registra un nuevo producto dentro del sistema usando transacciones SQL.
     *
     * Abre un bloque transaccional para garantizar la integridad referencial. Si la sentencia
     * de inserción falla o arroja una excepción, ejecuta un rollback automático para deshacer cambios.
     *
     * @param array $data Estructura con la información del producto (sku, nombre, descripción, precios, etc.).
     * @return bool Retorna verdadero si el registro se completó correctamente; falso si se canceló la operación.
     */
    public function crear(array $data): bool{
        try{
            $this->conexion->beginTransaction();

            $sql = 'INSERT INTO productos 
            (sku, nombre, descripcion, precio_compra, precio_venta, existencia, imagen)
            VALUES (:sku, :nombre, :descripcion, :precio_compra,
            :precio_venta, :existencia, :imagen)';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':sku', $data['sku']);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':descripcion', $data['descripcion']);
            $stmt->bindParam(':precio_compra', $data['precio_compra']);
            $stmt->bindParam(':precio_venta', $data['precio_venta']);
            $stmt->bindParam(':existencia', $data['existencia'], PDO::PARAM_INT);
            $stmt->bindParam(':imagen', $data['imagen']);

            $resultado = $stmt->execute();
            if (!$resultado){
                $this->conexion->rollBack();
                return false;
            }

            $this->conexion->commit();
            return true;
        } catch (PDOException $e){
            if ($this->conexion->inTransaction()){
                $this->conexion->rollBack();
            }
            return false;
        }
    }

    /**
     * Modifica los valores de un producto preexistente usando aislamiento transaccional.
     *
     * Ejecuta una sentencia UPDATE vinculando parámetros de forma segura y efectúa un
     * rollback en caso de que ocurra algún error del driver o base de datos.
     *
     * @param int $id Identificador del producto que se desea modificar.
     * @param array $data Conjunto estructurado con los nuevos valores para las columnas.
     * @return bool Retorna verdadero si los datos se actualizaron con éxito; falso si se rechazaron.
     */
    public function actualizar(int $id, array $data): bool{
        try{
            $this->conexion->beginTransaction();

            $sql = 'UPDATE productos SET 
                sku = :sku, 
                nombre = :nombre, 
                descripcion = :descripcion, 
                precio_compra = :precio_compra, 
                precio_venta = :precio_venta, 
                existencia = :existencia,
                imagen = :imagen
            WHERE id = :id';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':sku', $data['sku']);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':descripcion', $data['descripcion']);
            $stmt->bindParam(':precio_compra', $data['precio_compra']);
            $stmt->bindParam(':precio_venta', $data['precio_venta']);
            $stmt->bindParam(':existencia', $data['existencia'], PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':imagen', $data['imagen']);
            $stmt->execute();

            $this->conexion->commit();
            return true;
        } catch (PDOException $e){
            if ($this->conexion->inTransaction()){
                $this->conexion->rollBack();
            }
            return false;
        }
    }

    /**
     * Elimina físicamente un producto del sistema.
     *
     * Comprueba mediante `rowCount` que la fila haya sido suprimida con éxito.
     * Si el conteo es cero (porque el ID no existía), revierte la transacción.
     *
     * @param int $id Identificador del producto a remover.
     * @return bool Retorna verdadero si la fila fue borrada; falso si se canceló la consulta.
     */
    public function eliminar(int $id): bool{
        try{
            $this->conexion->beginTransaction();

            $sql = 'DELETE FROM productos WHERE id = :id';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() === 0){
                $this->conexion->rollBack();
                return false;
            }

            $this->conexion->commit();
            return true;
        } catch (PDOException $e){
            if ($this->conexion->inTransaction()){
                $this->conexion->rollBack();
            }
            return false;
        }
    }

    // Buscar si el SKU ya existe en la base de datos
    /**
     * Valida la existencia de un código SKU para prevenir duplicaciones.
     *
     * Permite omitir de la verificación un ID específico, lo cual es imprescindible
     * para evitar que un producto se bloquee a sí mismo durante sus actualizaciones de datos.
     *
     * @param string $sku Código único identificador de almacén.
     * @param int $idExcluir Identificador del producto actual que se desea omitir de la validación.
     * @return bool Retorna verdadero si el SKU ya está ocupado por otro producto; falso si está disponible.
     */
    public function existeSku(string $sku, int $idExcluir = 0): bool{
        try{
            $sql = 'SELECT COUNT(*) FROM productos WHERE sku = :sku AND id != :id';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':sku', $sku);
            $stmt->bindParam(':id', $idExcluir, PDO::PARAM_INT);
            $stmt->execute();
            return (int)$stmt->fetchColumn() > 0;
        } catch (PDOException $e){
            return false;
        }
    }

    // Contar el total de productos para la paginacion
    /**
     * Calcula la cantidad total de registros que coinciden con un criterio de filtrado.
     *
     * Método indispensable para abastecer de datos matemáticos precisos a las estructuras
     * y controles de paginación del lado del controlador de la vista.
     *
     * @param string $termino Expresión de búsqueda opcional por coincidencia de texto.
     * @return int Número total de filas encontradas en la tabla.
     */
    public function contarPublico(string $termino = ''): int {
        try {
            if (trim($termino) === '') {
                $sql = 'SELECT COUNT(*) FROM productos';
                $stmt = $this->conexion->query($sql);
            } else {
                $sql = 'SELECT COUNT(*) FROM productos WHERE nombre LIKE :termino OR descripcion LIKE :termino';
                $stmt = $this->conexion->prepare($sql);
                $busqueda = '%' . $termino . '%';
                $stmt->bindParam(':termino', $busqueda);
                $stmt->execute();
            }
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    // Obtener productos paginados
    /**
     * Extrae un fragmento o segmento específico de la lista de productos (Paginación).
     *
     * Vincula parámetros numéricos para las instrucciones SQL `LIMIT` y `OFFSET`,
     * asegurando que la base de datos procese eficientemente solo los registros visibles por pantalla.
     *
     * @param int $limite Número máximo de productos que se van a retornar por página.
     * @param int $offset Cantidad de registros que se omitirán desde el inicio de la tabla.
     * @param string $termino Filtro opcional para segmentar búsquedas específicas.
     * @return array Listado de productos pertenecientes a la página solicitada.
     */
    public function obtenerPaginados(int $limite, int $offset, string $termino = ''): array {
        try {
            if (trim($termino) === '') {
                $sql = 'SELECT * FROM productos ORDER BY id DESC LIMIT :limite OFFSET :offset';
                $stmt = $this->conexion->prepare($sql);
            } else {
                $sql = 'SELECT * FROM productos WHERE nombre LIKE :termino OR descripcion LIKE :termino ORDER BY id DESC LIMIT :limite OFFSET :offset';
                $stmt = $this->conexion->prepare($sql);
                $busqueda = '%' . $termino . '%';
                $stmt->bindParam(':termino', $busqueda);
            }
            
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
}