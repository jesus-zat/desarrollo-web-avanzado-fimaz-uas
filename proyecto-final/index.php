<?php
//Jesúa Zatarain Tirado LISI 3-1
/**
 * Front Controller (Enrutador Central)
 *
 * Este archivo actúa como el punto de entrada único para todas las peticiones HTTP
 * de la aplicación. Su función principal es:
 * 1. Definir las constantes de entorno y rutas base.
 * 2. Cargar el autoloader de clases mediante namespaces.
 * 3. Analizar y normalizar la ruta (URL) solicitada.
 * 4. Implementar un enrutador basado en switch para delegar la ejecución a los controladores.
 * 5. Gestionar la redirección de peticiones POST de búsqueda hacia URLs amigables.
 *
 * @package Core
 * @uses Config\Autoload Sistema de carga automática de clases (Namespaces).
 * @global string BASE_URL URL raíz de la aplicación para enlaces dinámicos.
 * @global string BASE_PATH Ruta absoluta en el servidor para operaciones de archivo.
 */

// Definición de constantes de entorno
$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
define('BASE_URL', $baseDir);
define('BASE_PATH', __DIR__);

// Carga de dependencias mediante autoloader
require_once __DIR__ . '/config/Autoload.php';

use Controllers\AuthController;
use Controllers\ProductoController;
use Controllers\PublicController;
use Controllers\BitacoraController;

// Normalización de la ruta solicitada
$route = isset($_GET['route']) ? rtrim($_GET['route'], '/') : 'catalogo';
$parts = explode('/', $route);
$controller_route = $parts[0] . (isset($parts[1]) ? '/' . $parts[1] : '');

// Instanciación de controladores
$authController = new AuthController();
$productoController = new ProductoController();
$publicController = new PublicController();
$bitacoraController = new BitacoraController();

/**
 * Switch de enrutamiento principal.
 * * Evalúa $controller_route para ejecutar la acción correspondiente en el 
 * controlador destino o manejar la API.
 */
switch($controller_route){
    case 'api/productos':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $productoController->getProductsAPI();
        }
        break;

    case 'login':
        $authController->showLogin();
        break;

    case 'auth/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $authController->login();
        }
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'productos':
        $productoController->index();
        break;

    case 'productos/create':
        $productoController->create();
        break;

    case 'productos/store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $productoController->store();
        }
        break;

    case 'productos/edit':
        if (isset($parts[2])) {
            $_GET['id'] = $parts[2]; 
        }
        $productoController->edit();
        break;

    case 'productos/update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $productoController->update();
        }
        break;

    case 'productos/delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $productoController->delete();
        }
        break;
    
    case 'bitacora':
        $bitacoraController->listar();
        break;

    case 'catalogo/buscar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $termino = $_POST['termino'] ?? '';
            // Redirigimos a la URL limpia: /catalogo/termino
            header("Location: " . BASE_URL . "catalogo/" . urlencode($termino));
            exit;
        }
        break;

    case 'catalogo':
    default:
        if (isset($parts[1]) && !empty($parts[1])) {
                // Pasamos el valor de búsqueda al Controlador vía $_GET
                $_GET['buscar'] = $parts[1]; 
             }
        $publicController->catalogo();
        break;
}