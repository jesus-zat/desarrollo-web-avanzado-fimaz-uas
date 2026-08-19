<?php
namespace Controllers;

use Models\ProductoModel;
use Models\BitacoraModel;

/**
 * Gestión de Productos (ProductoController)
 *
 * Clase encargada de coordinar el ciclo de vida del catálogo de productos.
 * Controla las verificaciones de seguridad (Sesiones y CSRF), operaciones CRUD,
 * procesamiento y almacenamiento seguro de imágenes, auditoría en bitácora
 * y exposición de datos a través de servicios API JSON.
 */
class ProductoController{
    /**
     * @var ProductoModel Instancia del modelo de productos para interactuar con la base de datos.
     */
    private ProductoModel $productoModel;
    
    /**
     * @var BitacoraModel Instancia del modelo de bitácora para el registro histórico de operaciones.
     */
    private BitacoraModel $bitacora;
    
    /**
     * @var mixed Almacena el identificador del usuario administrador en la sesión actual.
     */
    private $usuario;

    /**
     * Inicializa el controlador construyendo las instancias necesarias para operar.
     */
    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->bitacora = new BitacoraModel();
    }

    /**
     * Verifica la existencia de una sesión válida de administrador.
     *
     * Inicializa el sistema de sesiones de PHP si no se ha iniciado antes y
     * comprueba los privilegios. Si no se detectan credenciales activas,
     * detiene el flujo y redirige a la interfaz de login.
     *
     * @return void
     */
    public function verificarSesion(): void{
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if (!isset($_SESSION['admin'])){
            header('Location: '. BASE_URL .'login');
            exit;
        }

        $this->usuario = $_SESSION['admin']['username'] ?? 'Invitado';
    }

    /**
     * Muestra la vista del catálogo general de productos.
     *
     * Invoca la validación de sesión activa, recopila todos los registros de
     * productos desde el modelo y los transfiere a la vista correspondiente.
     *
     * @return void
     */
    public function index(): void{
        $this->verificarSesion();
        $productos = $this->productoModel->obtenerTodos();
        require_once __DIR__ . '/../views/productos/index.php';
    }

    /**
     * Carga el formulario de registro para un nuevo producto.
     *
     * Garantiza la autenticación del usuario antes de desplegar la vista de inserción.
     *
     * @return void
     */
    public function create(): void{
        $this->verificarSesion();
        require_once __DIR__ . '/../views/productos/create.php';
    }

    /**
     * Procesa y almacena un nuevo producto en el sistema.
     *
     * Valida la integridad de la petición por token CSRF, limpia las entradas POST,
     * comprueba campos obligatorios, restricciones numéricas y de negocio (precios no negativos,
     * relación costo/venta, SKU único). Administra la subida y renombrado único de imágenes
     * antes de persistir la información y registrar el evento en la bitácora.
     *
     * @return void
     */
    public function store(): void {
        $this->verificarSesion();
        $this->validarCSRF();

        $data = [
            'sku' => trim($_POST['sku'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio_compra' => trim($_POST['precio_compra'] ?? ''),
            'precio_venta' => trim($_POST['precio_venta'] ?? ''),
            'existencia' => trim($_POST['existencia'] ?? '')
        ];

        if (
            $data['sku'] === '' ||
            $data['nombre'] === '' ||
            $data['descripcion'] === '' ||
            $data['precio_compra'] === '' ||
            $data['precio_venta'] === '' ||
            $data['existencia'] === ''
        ){
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: '. BASE_URL .'productos/create');
            exit;
        }

        if (!is_numeric($data['precio_compra']) || !is_numeric($data['precio_venta'])
        || !is_numeric($data['existencia'])) {
            $_SESSION['error'] = 'Precio de compra, precio de venta y existencia deben ser numéricos.';
            header('Location: '. BASE_URL .'productos/create');
            exit;
        }

        if ((float)$data['precio_compra'] < 0 || (float)$data['precio_venta'] < 0 ){
            $_SESSION['error'] = 'No se permiten valores negativos.';
            header('Location: '. BASE_URL .'productos/create');
            exit;
        }

        // Validar que el precio de venta sea mayor o igual al de compra
        if ((float)$data['precio_venta'] < (float)$data['precio_compra']) {
            $_SESSION['error'] = 'El precio de venta no puede ser menor al precio de compra.';
            header('Location: '. BASE_URL .'productos/create');
            exit;
        }

        // Validar que el stock no sea negativo
        if ((int)$data['existencia'] < 0) {
            $_SESSION['error'] = 'La existencia no puede ser menor a cero.';
            header('Location: '. BASE_URL .'productos/create');
            exit;
        }

        // Validar SKU unico
        if ($this->productoModel->existeSku($data['sku'])) {
            $_SESSION['error'] = 'El SKU ingresado ya está registrado.';
            header('Location: '. BASE_URL .'productos/create');
            exit;
        }

        // empezar diciendo que no hay foto por si no suben nada
        $nombreImagen = null;
        // revisar si mandaron un archivo y si no tiene errores de subida
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // sacar la extension de la foto (jpg, png, etc.)
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            // armar un nombre unico mezclando la hora y un id raro para que no se repitan
            $nombreImagen = time() . '_' . uniqid() . '.' . $ext;
            // decirle a donde queremos mandar la foto guardada (carpeta img)
            $rutaDestino = __DIR__ . '/../views/img/' . $nombreImagen;
            // mover el archivo temporal que te da php a nuestra carpeta real
            move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
        }
        // meter el nombre final de la foto al array que va para la base de datos
        $data['imagen'] = $nombreImagen;

        if ($this->productoModel->crear($data)){
            $this->bitacora->log($this->usuario, "Producto ". $data['nombre'] ." agregado");
            $_SESSION['success'] = 'Producto registrado correctamente.';
        } else {
            $this->bitacora->log($this->usuario, "FALLO al agregar nuevo producto");
            $_SESSION['error'] = 'No fue posible registrar el producto';
        }

        header('Location: '. BASE_URL .'productos');
        exit;
    }

    /**
     * Muestra la vista de edición cargando la información de un producto específico.
     *
     * Verifica la sesión, procesa el identificador enviado mediante GET, y solicita
     * la información del registro. En caso de no encontrar coincidencias, redirige
     * notificando el percance.
     *
     * @return void
     */
    public function edit(): void{
        $this->verificarSesion();
        $id = (int)($_GET['id'] ?? 0);
        $producto = $this->productoModel->obtenerPorId($id);

        if (!$producto){
            $_SESSION['error'] = 'Producto no encontrado.';
            header('Location: '. BASE_URL .'productos');
            exit;
        }

        require_once __DIR__ . '/../views/productos/edit.php';
    }

    /**
     * Procesa la actualización de los datos de un producto determinado.
     *
     * Valida el token CSRF y analiza los datos modificados. Si se detecta la carga
     * de una nueva imagen, se genera un nombre único para guardarla en el disco y se
     * remueve físicamente el archivo de imagen obsoleto para optimizar almacenamiento.
     *
     * @return void
     */
    public function update(): void{
        $this->verificarSesion();
        $this->validarCSRF();

        $id = (int)($_POST['id'] ?? 0);

        $data = [
            'sku' => trim($_POST['sku'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio_compra' => trim($_POST['precio_compra'] ?? ''),
            'precio_venta' => trim($_POST['precio_venta'] ?? ''),
            'existencia' => trim($_POST['existencia'] ?? '')
        ];

        if ($id <= 0){
            $_SESSION['error'] = 'ID inválido.';
            header('Location: '. BASE_URL .'productos');
            exit;
        }

        if(
            $data['sku'] === '' ||
            $data['nombre'] === '' ||
            $data['descripcion'] === '' ||
            $data['precio_compra'] === '' ||
            $data['precio_venta'] === '' ||
            $data['existencia'] === '')
        {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: '. BASE_URL .'productos/edit/' . $id);
            exit;
        }

        if (!is_numeric($data['precio_compra']) || !is_numeric($data['precio_venta'])
        || !is_numeric($data['existencia'])) {
            $_SESSION['error'] = 'Precio de compra, precio de venta y existencia deben ser numéricos.';
            header('Location: '. BASE_URL .'productos/edit/' . $id);
            exit;
        }

        if ((float)$data['precio_compra'] < 0 || (float)$data['precio_venta'] < 0){
            $_SESSION['error'] = 'No se permiten valores negativos.';
            header('Location: '. BASE_URL .'productos/edit/' . $id);
            exit;
        }

        // Validar que el precio de venta sea mayor o igual al de compra
        if ((float)$data['precio_venta'] < (float)$data['precio_compra']) {
            $_SESSION['error'] = 'El precio de venta no puede ser menor al precio de compra.';
            header('Location: '. BASE_URL .'productos/edit/' . $id);
            exit;
        }

        // Validar que el stock no sea negativo
        if ((int)$data['existencia'] < 0) {
            $_SESSION['error'] = 'La existencia no puede ser menor a cero.';
            header('Location: '. BASE_URL .'productos/edit/' . $id);
            exit;
        }

        // validar sku unico pasando el id para que no se bloquee a si mismo
        if ($this->productoModel->existeSku($data['sku'], $id)) {
            $_SESSION['error'] = 'El SKU ingresado ya pertenece a otro producto.';
            header('Location: '. BASE_URL .'productos/edit/' . $id);
            exit;
        }

        // consultar el producto como esta ahorita para ver si ya tenia foto
        $productoActual = $this->productoModel->obtenerPorId($id);
        $nombreImagen = $productoActual['imagen'] ?? null;
        // si subieron una foto nueva en este momento, hacemos el cambio
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombreImagen = time() . '_' . uniqid() . '.' . $ext;
            $rutaDestino = __DIR__ . '/../views/img/' . $nombreImagen;
            
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                // si el producto ya tenia una foto vieja guardada, la borramos para no llenar la carpeta de basura
                if (!empty($productoActual['imagen'])) {
                    $fotoVieja = __DIR__ . '/../views/img/' . $productoActual['imagen'];
                    if (file_exists($fotoVieja)) {
                        unlink($fotoVieja); // unlink borra archivos en php
                    }
                }
            }
        }
        // actualizar el array con la foto nueva o la que ya tenia
        $data['imagen'] = $nombreImagen;

        if ($this->productoModel->actualizar($id, $data)){
            $this->bitacora->log($this->usuario, "Producto con ID ".$id." actualizado");
            $_SESSION['success'] = 'Producto actualizado correctamente.';
        } else {
            $this->bitacora->log($this->usuario, "FALLO al actualizar producto con ID ".$id);
            $_SESSION['error'] = 'No fue posible actualizar el producto.';
        }

        header('Location: '. BASE_URL .'productos');
        exit;
    }

    /**
     * Elimina un producto de manera permanente.
     *
     * Ejecuta validaciones de sesión y CSRF, verifica la validez del ID y,
     * tras borrar el registro de la base de datos de manera exitosa, destruye
     * físicamente el archivo de imagen vinculado al disco local si este existía.
     *
     * @return void
     */
    public function delete(): void{
        $this->verificarSesion();
        $this->validarCSRF();
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0){
            $_SESSION['error'] = 'ID inválido.';
            header('Location: '. BASE_URL .'productos');
            exit;
        }

        // buscar el producto antes de borrarlo para ver si tiene foto guardada
        $producto = $this->productoModel->obtenerPorId($id);
        if ($this->productoModel->eliminar($id)){
            $this->bitacora->log($this->usuario, "Producto con ID ".$id." eliminado");
            // si se borro bien de la base de datos y tenia foto, la borramos del disco
            if ($producto && !empty($producto['imagen'])) {
                $rutaFoto = __DIR__ . '/../views/img/' . $producto['imagen'];
                if (file_exists($rutaFoto)) {
                    unlink($rutaFoto);
                }
            }
            $_SESSION['success'] = 'Producto eliminado correctamente.';
        } else {
            $this->bitacora->log($this->usuario, "FALLO al intentar eliminar producto ID: " . $id);
            $_SESSION['error'] = 'No fue posible eliminar el producto.';
        }

        header('Location: '. BASE_URL .'productos');
        exit;
    }

    /**
     * Expone el catálogo completo de productos en formato API RESTful.
     *
     * Inyecta las cabeceras HTTP nativas necesarias para responder en JSON y
     * habilitar las políticas de control de acceso CORS. Devuelve los registros
     * con código de respuesta 200 o un mensaje de error con estatus 404.
     *
     * @return void
     */
    public function getProductsAPI(): void {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

        $productos = $this->productoModel->obtenerTodos();

        if (!empty($productos)){
            http_response_code(200);
            echo json_encode($productos, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "No se encontraron productos"]);
        }
        exit;
    }

    /**
     * Valida el token de seguridad contra Falsificación de Petición en Sitios Cruzados.
     *
     * Compara de forma estricta el token CSRF adjunto en la petición POST contra el
     * token resguardado en la sesión activa del servidor, bloqueando intrusiones.
     *
     * @return void
     */
    private function validarCSRF(): void {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Error de seguridad: Intento de falsificación de petición (CSRF).";
            header('Location: ' . BASE_URL . 'productos');
            exit;
        }
    }
}
?>