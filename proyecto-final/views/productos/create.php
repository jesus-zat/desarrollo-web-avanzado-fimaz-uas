<?php
//Jesús Zatarain Tirado LISI 3-1
/**
 * Vista de Administración - Formulario de Alta de Productos
 *
 * Despliega una interfaz de formulario estructurada para la captura y registro
 * de nuevos productos en el sistema. Implementa soporte nativo para la carga de
 * archivos multimedia (imágenes) mediante atributos de codificación multipart, 
 * e incluye mecanismos de protección contra falsificación de peticiones en sitios
 * cruzados utilizando un campo oculto inyectado con el token CSRF de la sesión.
 *
 * @package Views
 * @subpackage Admin
 * @uses BASE_URL Constante global para la resolución de rutas relativas y absolutas del proyecto.
 * @requires views/layouts/header.php Componente de cabecera general de la aplicación.
 * @requires views/layouts/footer.php Componente de pie de página general de la aplicación.
 * @global array $_SESSION['csrf_token'] Clave criptográfica utilizada para validar la legitimidad del origen del formulario.
 * @global string $_SESSION['error'] Mensaje flash de error local en caso de fallas de validación específicas.
 */
require_once __DIR__ . '/../layouts/header.php'; 
?>

<h2>Registrar producto</h2>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>
<form action="<?= BASE_URL ?>productos/store" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <div class="mb-3">
        <label class="form-label">SKU</label>
        <input type="text" name="sku" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea type="text" name="descripcion" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Precio compra</label>
        <input type="number" step="0.01" name="precio_compra" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Precio venta</label>
        <input type="number" step="0.01" name="precio_venta" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Existencia</label>
        <input type="number" name="existencia" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Imagen del producto</label>
        <input type="file" name="imagen" class="form-control" accept="image/*">
    </div>

    <button class="btn btn-success" type="submit">Guardar</button>
    <a href="<?= BASE_URL ?>productos" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>