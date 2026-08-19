<?php
//Jesús Zatarain Tirado LISI 3-1

namespace Controllers;

use Models\ProductoModel;

/**
 * Controlador Público del Catálogo (PublicController)
 *
 * Clase encargada de gestionar las interfaces de acceso público al sistema,
 * controlando la visualización del catálogo de productos, el filtrado por búsquedas
 * y la segmentación de datos en páginas.
 */
class PublicController{
    
    /**
     * Despliega la vista del catálogo público con soporte de búsqueda y paginación.
     *
     * Recupera los términos de búsqueda opcionales desde la URL, calcula la página
     * actual evitando desbordamientos inferiores y superiores, computa el desplazamiento
     * (offset) de filas para la consulta SQL y transfiere el set segmentado de productos a la vista.
     *
     * @return void
     */
    public function catalogo(): void{
        $termino = trim($_GET['buscar'] ?? '');
        // sacar la pagina actual del get
        $paginaActual = (int)($_GET['p'] ?? 1);
        if ($paginaActual < 1) {
            $paginaActual = 1;
        }

        $productosPorPagina = 6; // cantidad de filas por pagina
        $offset = ($paginaActual - 1) * $productosPorPagina;
        $productoModel = new ProductoModel();
        $totalProductos = $productoModel->contarPublico($termino);
        $totalPaginas = (int)ceil($totalProductos / $productosPorPagina);
        // si la pagina es mas alta que el total, nos quedamos en la ultima
        if ($totalPaginas > 0 && $paginaActual > $totalPaginas) {
            $paginaActual = $totalPaginas;
            $offset = ($paginaActual - 1) * $productosPorPagina; // actualizar el offset real
        }

        $productos = $productoModel->obtenerPaginados($productosPorPagina, $offset, $termino);

        require_once __DIR__ . '/../views/public/catalogo.php';
    }
}
?>