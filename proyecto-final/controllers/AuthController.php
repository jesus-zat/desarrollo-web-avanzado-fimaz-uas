<?php
//Jesús Zatarain Tirado LISI 3-1

namespace Controllers;

use Models\UsuarioModel;

/**
 * Control de Autenticación y Sesiones (AuthController)
 *
 * Clase encargada de gestionar el flujo de acceso al sistema, validando las
 * credenciales de los usuarios, administrando el estado de las sesiones activas
 * y protegiendo el acceso no autorizado.
 */
class AuthController{
    
    /**
     * Muestra la vista del formulario de inicio de sesión.
     *
     * Carga físicamente el archivo de la interfaz de Login para que el usuario
     * pueda ingresar sus credenciales de acceso.
     *
     * @return void
     */
    public function showLogin(): void{
        require_once __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Procesa y valida el intento de inicio de sesión.
     *
     * Verifica el estado de la sesión, limpia los datos recibidos mediante POST,
     * comprueba que los campos no estén vacíos, consulta al modelo de usuarios
     * y corrobora la contraseña encriptada. Si el acceso es correcto, guarda los
     * datos del administrador en la sesión y redirige al catálogo.
     *
     * @return void
     */
    public function login(): void{
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === '' || $password === ''){
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: '. BASE_URL .'login');
            exit;
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->buscarPorUsername($username);

        if ($usuario && password_verify($password, $usuario['password'])){
            $_SESSION['admin'] = [
                'id' => $usuario['id'],
                'username' => $usuario['username'],
                'nombre_completo' => $usuario['nombre_completo']
            ];
            
            $_SESSION['success'] = 'Bienvenido, '.$usuario['nombre_completo'] . '.';
            header('Location: '. BASE_URL .'productos');
            exit;
        }

        $_SESSION['error'] = 'Credenciales incorrectas.';
        header('Location: '. BASE_URL .'login');
        exit;
    }

    /**
     * Cierra la sesión activa del usuario.
     *
     * Asegura la inicialización de la sesión antes de destruirla por completo,
     * eliminando todas las variables del servidor y redirigiendo al formulario de login.
     *
     * @return void
     */
    public function logout(): void{
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        session_destroy();
        header('Location: '. BASE_URL .'login');
        exit;
    }
}
?>