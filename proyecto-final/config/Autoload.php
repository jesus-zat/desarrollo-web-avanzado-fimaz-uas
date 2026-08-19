<?php
//Jesús Zatarain Tirado LISI 3-1
/**
 * Autoload de clases.
 *
 * Carga automáticamente los archivos de las clases cuando son necesarios,
 * evitando tener que utilizar require_once manualmente.
 *
 * @param string $class Nombre de la clase que se desea cargar.
 */
spl_autoload_register(function ($class) {

    // Define la carpeta principal del proyecto.
    $baseDir = __DIR__ . '/../';

    // Cambia los separadores de namespace por separadores de carpetas.
    $class = str_replace('\\', '/', $class);

    // Divide el nombre de la clase en partes.
    $parts = explode('/', $class);

    // Convierte la primera parte a minúsculas.
    if (!empty($parts)) {
        $parts[0] = strtolower($parts[0]);
    }

    // Construye la ruta del archivo de la clase.
    $file = $baseDir . implode('/', $parts) . '.php';

    // Verifica si el archivo existe antes de cargarlo.
    if (file_exists($file)) {
        require_once $file;
    }
});
?>