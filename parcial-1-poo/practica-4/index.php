<?php

// Importamos las clases necesarias
require_once "clases/Admin.php";
require_once "clases/Alumno.php";
require_once "clases/Invitado.php";

// Arreglo donde guardaremos los usuarios creados
$usuarios = [];

try {

    // Creamos un administrador válido
    $admin = new Admin("Carlos","carlos@gmail.com");
    $usuarios[] = $admin;

    // Creamos un alumno válido
    $alumno = new Alumno("Hector","hector@gmail.com","20888597");
    $usuarios[] = $alumno;

    // Creamos un invitado válido
    $invitado = new Invitado("Laura","laura@empresa.com","Google");
    $usuarios[] = $invitado;

    // Creamos un usuario con correo inválido para provocar la excepción
    $error = new Admin("Pedro","correo-invalido");

} catch (Exception $e){

    // Capturamos el error y mostramos un mensaje controlado
    echo "<p><b>Error controlado:</b> ".$e->getMessage()."</p>";

}

?>

<h2>Lista de usuarios</h2>

<table border="1" cellpadding="8">

<tr>
<th>Nombre</th>
<th>Correo</th>
<th>Rol</th>
<th>Matrícula</th>
<th>Empresa</th>
</tr>

<?php foreach($usuarios as $u): ?>

<tr>

<td><?php echo $u->getNombre(); ?></td>

<td><?php echo $u->getCorreo(); ?></td>

<td><?php echo $u->getRol(); ?></td>

<td>
<?php
// Si el usuario es Alumno mostramos matrícula
// Si no, mostramos —
echo ($u instanceof Alumno) ? $u->getMatricula() : "—";
?>
</td>

<td>
<?php
// Si el usuario es Invitado mostramos empresa
// Si no, mostramos —
echo ($u instanceof Invitado) ? $u->getEmpresa() : "—";
?>
</td>

</tr>

<?php endforeach; ?>

</table>