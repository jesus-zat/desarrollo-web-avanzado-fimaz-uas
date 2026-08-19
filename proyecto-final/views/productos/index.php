<?php
//Jesús Zatarain Tirado LISI 3-1
/**
 * Vista de Administración - Panel de Control del Inventario (CRUD)
 *
 * Renderiza la interfaz principal de gestión de productos exclusiva para operadores
 * autenticados. Despliega un catálogo tabular que incluye identificadores de almacén, 
 * previsualización controlada de imágenes fijando su relación de aspecto, y acciones directas
 * de mutación. Las eliminaciones se procesan de forma segura a través de formularios
 * individuales acoplados con validación de tokens CSRF y confirmación en el cliente.
 *
 * @package Views
 * @subpackage Admin
 * @uses BASE_URL Constante global para la resolución de rutas relativas y absolutas del proyecto.
 * @requires views/layouts/header.php Componente de cabecera general de la aplicación.
 * @requires views/layouts/footer.php Componente de pie de página general de la aplicación.
 * @global array $_SESSION['csrf_token'] Clave criptográfica para la autenticación de peticiones POST de eliminación.
 * @var array $productos {
 * Colección bidimensional de registros de productos recuperados para la cuadrícula administrativa.
 *
 * @type int|string $id Clave primaria del producto.
 * @type string $sku Código único identificador de almacén.
 * @type string $nombre Nombre comercial del artículo.
 * @type float|string $precio_compra Costo original de adquisición.
 * @type float|string $precio_venta Precio fijado para el consumidor final.
 * @type int $existencia Unidades disponibles en stock.
 * @type string|null $imagen Nombre o ruta del archivo binario de imagen.
 * }
 */
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Administración de productos</h2>
    <div>
        <a href="<?= BASE_URL ?>productos/create" class="btn btn-success">Nuevo producto</a>
        <a href="<?= BASE_URL ?>logout" class="btn btn-danger">Cerrar sesión</a>
    </div>
</div>

<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>SKU</th>
            <th>Nombre</th>
            <th>Precio compra</th>
            <th>Precio venta</th>
            <th>Existencia</th>
            <th>Imagen</th> 
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($productos as $producto): ?>
            <tr>
                <td><?= (int)$producto['id']; ?></td>
                <td><?= htmlspecialchars($producto['sku']); ?></td>
                <td><?= htmlspecialchars($producto['nombre']); ?></td>
                <td><?= htmlspecialchars($producto['precio_compra']); ?></td>
                <td><?= htmlspecialchars($producto['precio_venta']); ?></td>
                <td><?= (int)$producto['existencia']; ?></td>
                
                <td>
                    <?php if (!empty($producto['imagen'])): ?>
                        <img src="<?= BASE_URL ?>views/img/<?= htmlspecialchars($producto['imagen']); ?>" 
                             alt="Foto" 
                             class="img-thumbnail" 
                             style="width: 50px; height: 50px; object-fit: cover;">
                    <?php else: ?>
                        <span class="text-muted" style="font-size: 0.85rem;">Sin foto</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="<?= BASE_URL ?>productos/edit/<?= $producto['id']; ?>" 
                    class="btn btn-primary btn-sm">Editar</a>

                    <form action="<?= BASE_URL ?>productos/delete" method="POST" class="d-inline">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="id" value="<?= (int)$producto['id']; ?>">
                        <button class="btn btn-sm btn-danger" type="submit" 
                                onclick="return confirm('¿Deseas eliminar este producto?');">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="text-center mb-4">
    <a href="<?= BASE_URL ?>bitacora" class="btn btn-secondary">Bitácora de administrador</a>
</div>
<?php 
require_once __DIR__ . '/../layouts/footer.php'; 
?>