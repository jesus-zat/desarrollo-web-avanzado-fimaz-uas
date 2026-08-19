<?php
//Jesús Zatarain Tirado LISI 3-1
/**
 * Vista de Administración - Formulario de Modificación de Productos
 *
 * Despliega una interfaz precargada para la edición de las propiedades de un
 * producto existente. Utiliza la inyección de datos de forma segura mediante
 * funciones de escape para mitigar vulnerabilidades XSS, mantiene un campo oculto
 * con el identificador del registro (ID) y un token CSRF de control, e implementa
 * una estructura condicional visual para previsualizar la miniatura de la imagen actual.
 *
 * @package Views
 * @subpackage Admin
 * @uses BASE_URL Constante global para la resolución de rutas relativas y absolutas del proyecto.
 * @requires views/layouts/header.php Componente de cabecera general de la aplicación.
 * @requires views/layouts/footer.php Componente de pie de página general de la aplicación.
 * @global array $_SESSION['csrf_token'] Código criptográfico para la validación de peticiones seguras.
 * @global string $_SESSION['error'] Mensaje de alerta flash en caso de fallo en la validación del negocio.
 * @var array $producto {
 * Estructura asociativa con la información actual del producto cargado desde el controlador.
 *
 * @type int|string $id Identificador único del registro en la base de datos.
 * @type string $sku Código único identificador de almacén.
 * @type string $nombre Nombre descriptivo del producto.
 * @type string $descripcion Detalle extenso del artículo.
 * @type float|string $precio_compra Costo original de adquisición.
 * @type float|string $precio_venta Precio fijado para el consumidor final.
 * @type int $existencia Unidades disponibles en stock.
 * @type string|null $imagen Nombre del archivo binario o ruta de la imagen registrada.
 * }
 */
require_once __DIR__ . '/../layouts/header.php'; 
?>

<h2>Editar producto</h2>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<form action="<?= BASE_URL ?>productos/update" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="id" value="<?= (int)$producto['id']; ?>">
    <div class="mb-3">
        <label class="form-label">SKU</label>
        <input type="text" name="sku" class="form-control"
        value="<?= htmlspecialchars($producto['sku']); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" 
        value="<?= htmlspecialchars($producto['nombre']); ?>"required>
    </div>
    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion" class="form-control" 
        required><?= htmlspecialchars($producto['descripcion']); ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Precio compra</label>
        <input type="number" step="0.01" name="precio_compra" class="form-control" 
        value="<?= htmlspecialchars((string)$producto['precio_compra']); ?>"required>
    </div>
    <div class="mb-3">
        <label class="form-label">Precio venta</label>
        <input type="number" step="0.01" name="precio_venta" class="form-control"
        value="<?= htmlspecialchars((string)$producto['precio_venta']); ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Existencia</label>
        <input type="number" name="existencia" class="form-control" 
        value="<?= (int)$producto['existencia']; ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Imagen del producto</label>
        <?php if (!empty($producto['imagen'])): ?>
            <div class="mb-2">
                <small class="text-muted d-block mb-1">Imagen actual:</small>
                <img src="<?= BASE_URL ?>views/img/<?= htmlspecialchars($producto['imagen']); ?>" alt="Foto" class="img-thumbnail" style="max-width: 150px; height: auto;">
            </div>
        <?php else: ?>
            <div class="mb-2">
                <span class="badge bg-secondary">Sin imagen registrada</span>
            </div>
        <?php endif; ?>
        
        <input type="file" name="imagen" class="form-control" accept="image/*">
        <small class="form-text text-muted">Selecciona un archivo solo si deseas cambiar la foto actual.</small>
    </div>
    
    <button class="btn btn-primary" type="submit">Actualizar</button>
    <a href="<?= BASE_URL ?>productos" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>