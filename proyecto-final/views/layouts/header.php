<?php 
//Jesús Zatarain Tirado LISI 3-1
/**
 * Layout de Apertura - Cabecera General (Header)
 *
 * Este componente inicializa el estado de la sesión si no ha sido iniciado,
 * genera un token criptográfico CSRF seguro para la protección de formularios,
 * carga las dependencias de Bootstrap 5 en el cliente y gestiona la renderización
 * de mensajes flash de éxito o error almacenados en la sesión.
 *
 * @package Views
 * @subpackage Layouts
 * @uses BASE_URL Constante global para la resolución de rutas relativas y absolutas del proyecto.
 * @global array $_SESSION['csrf_token'] Almacena el token de seguridad para validación de peticiones POST.
 * @global string $_SESSION['success'] Mensaje flash de operación exitosa (se elimina tras renderizar).
 * @global string $_SESSION['error'] Mensaje flash de error en la operación (se elimina tras renderizar).
 */

if (session_status() === PHP_SESSION_NONE) session_start(); 
// Si no existe un token para esta sesión, lo creamos
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Desarrollo Web Avanzado: POO+PDO+TryCatch-Namespaces-Autoload-Transacciones-MVC</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="<?= BASE_URL ?>" class="navbar-brand">Tienda MVC</a>
                <div>
                    <a href="<?= BASE_URL ?>" class="btn btn-outline-light btn-sm me-2">Catálogo</a>
                    <a href="<?= BASE_URL ?>login" class="btn btn-warning btn-sm">Administrador</a>
                </div>
            </div>
        </nav>
        <div class="container mt-4">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>