<?php
//Jesúa Zatarain Tirado LISI 3-1
/**
 * Vista de Catálogo Público - Navegación de Inventario
 *
 * Interfaz principal orientada al consumidor final. Permite visualizar el catálogo
 * disponible, ejecutar filtros de búsqueda por texto y navegar a través de los resultados
 * mediante un sistema de paginación. Gestiona la presentación visual de las tarjetas
 * de producto, incluyendo el formateo de precios, el escape de caracteres para seguridad XSS,
 * y la renderización condicional de imágenes.
 *
 * @package Views
 * @subpackage Public
 * @uses BASE_URL Constante global para la resolución de rutas relativas y absolutas del proyecto.
 * @requires views/layouts/header.php Componente de cabecera general de la aplicación.
 * @requires views/layouts/footer.php Componente de pie de página general de la aplicación.
 * @var array $productos Colección de registros de productos recuperados para la página actual.
 * @var string $termino El criterio de búsqueda persistido en el input de filtrado.
 * @var int $paginaActual Número de página seleccionada actualmente.
 * @var int $totalPaginas Número total de páginas disponibles para navegación.
 */
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2>Catálogo público de productos</h2>
        <p>Consulta los productos disponibles y realiza búsquedas 
            por nombre o descripción.
        </p>
    </div>
</div>

<form action="<?= BASE_URL ?>catalogo/buscar" method="POST" class="row g-2 mb-4">
    <div class="col-md-10">
        <input type="text" name="termino" class="form-control" 
               placeholder="Buscar por nombre o descripción"
               value="<?= htmlspecialchars($termino ?? ''); ?>">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Buscar</button>
    </div>
</form>

<div class="row">
    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $producto): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    
                    <div style="height: 200px; overflow: hidden; background-color: #f8f9fa;" class="d-flex align-items-center justify-content-center">
                        <?php if (!empty($producto['imagen'])): ?>
                            <img src="<?= BASE_URL ?>views/img/<?= htmlspecialchars($producto['imagen']); ?>" 
                                 alt="<?= htmlspecialchars($producto['nombre']); ?>" 
                                 class="card-img-top" 
                                 style="object-fit: contain; height: 100%; width: 100%;">
                        <?php else: ?>
                            <div class="text-muted text-center">
                                <small class="d-block">Sin imagen</small>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($producto['nombre']); ?></h5>
                        <h5 class="card-subtitle mb-2 text-muted">SKU: <?= htmlspecialchars($producto['sku']); ?></h5>
                        <p class="card-text"><?= htmlspecialchars($producto['descripcion']); ?></p>
                        <p><strong>Precio:</strong> $<?= number_format((float)$producto['precio_venta'], 2); ?></p>
                        <p><strong>Existencia: </strong> <?= (int)$producto['existencia']; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if ($totalPaginas > 1): ?>
            <div class="col-12 mt-4">
                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= ($paginaActual <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?route=catalogo&buscar=<?= urlencode($termino) ?>&p=<?= $paginaActual - 1 ?>">Anterior</a>
                        </li>
                        
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <li class="page-item <?= ($paginaActual == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?route=catalogo&buscar=<?= urlencode($termino) ?>&p=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?= ($paginaActual >= $totalPaginas) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?route=catalogo&buscar=<?= urlencode($termino) ?>&p=<?= $paginaActual + 1 ?>">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-warning">No se encontraron productos.</div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>