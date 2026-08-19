<?php
//Jesús Zatarain Tirado LISI 3-1
/**
 * Vista de Autenticación - Formulario de Login
 *
 * Interfaz de usuario para el inicio de sesión administrativo. Despliega un panel
 * con campos validados en el cliente para capturar las credenciales (usuario y contraseña)
 * y enviarlas vía POST hacia el controlador de autenticación.
 *
 * @package Views
 * @subpackage Auth
 * * @uses BASE_URL Constante global para la resolución de rutas relativas y absolutas del proyecto.
 * @requires views/layouts/header.php Componente de cabecera general de la aplicación.
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                Iniciar Sesión
            </div>
            <div class="card-body">
                <form action="<?= BASE_URL ?>auth/login" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button class="btn btn-primary w-100" type="submit">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>