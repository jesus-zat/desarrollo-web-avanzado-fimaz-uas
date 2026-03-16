<?php

require_once "clases/Admin.php";
require_once "clases/Alumno.php";

$usuarios = array();
$error = "";

try{

    // Admin válido
    $objAdmin = new Admin("Jesus Zatarain","jesusitojzt@gmail.com");
    $usuarios[] = $objAdmin;

    // Alumno válido
    $objAlumno = new Alumno("Maria Perez","maria@gmail.com",20888597);
    $usuarios[] = $objAlumno;

    // Usuario con correo inválido (provoca excepción)
    $objError = new Alumno("Pedro","correo-invalido",12345);
    $usuarios[] = $objError;

}catch(Exception $e){

    // Mensaje de error controlado
    $error = $e->getMessage();

}

?>

<h2>Lista de usuarios</h2>

<table border="1">

<tr>
<th>Nombre</th>
<th>Correo</th>
<th>Rol</th>
<th>Matricula</th>
</tr>

<?php foreach($usuarios as $usuario){ ?>

<tr>

<td><?php echo $usuario->getNombre(); ?></td>
<td><?php echo $usuario->getCorreo(); ?></td>
<td><?php echo $usuario->getRol(); ?></td>

<td>
<?php
if($usuario instanceof Alumno){
    echo $usuario->getMatricula();
}else{
    echo "-";
}
?>
</td>

</tr>

<?php } ?>

<?php if($error != ""){ ?>

<tr>
<td colspan="4"><b>Error controlado:</b> <?php echo $error; ?></td>
</tr>

<?php } ?>

</table>