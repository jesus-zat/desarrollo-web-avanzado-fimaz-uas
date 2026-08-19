<?php
//Jesús Zatarain Tirado LISI 3-1

namespace Controllers;
use Models\BitacoraModel;

/**
 * Control de Bitácora del Sistema (BitacoraController)
 *
 * Clase encargada de gestionar el flujo de visualización de los registros
 * de auditoría, eventos y acciones del sistema almacenados en la base de datos.
 */
class BitacoraController {
    /**
     * @var BitacoraModel Instancia del modelo encargado de las consultas de bitácora.
     */
    private BitacoraModel $bitacoraModel;

    /**
     * Inicializa el controlador y crea la instancia del modelo de bitácora.
     */
    public function __construct() {
        $this->bitacoraModel = new BitacoraModel(); 
    }

    /**
     * Muestra la interfaz principal con el historial de eventos.
     *
     * Recupera la totalidad de los logs registrados en el sistema a través del modelo
     * y los disponibiliza para su renderizado en la vista del módulo.
     *
     * @return void
     */
    public function listar() {

        // Obtenemos todos los registros de la base de datos
        $logs = $this->bitacoraModel->listarTodos();

        // 3. VISTA: Cargamos el layout profesional
        require_once 'views/bitacora/index.php';
    }
}