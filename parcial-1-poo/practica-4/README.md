# Documentacion

## Funcionamiento

El sistema crea diferentes tipos de usuarios:

- Administrador
- Alumno
- Invitado

Todos heredan de la clase base Usuario.

El constructor de Usuario valida que el correo tenga un formato válido.  
Si el correo es incorrecto se lanza una Exception.

En index.php se utiliza try/catch para capturar el error y mostrar un mensaje controlado.

## Evidencia esperada

Al ejecutar el programa se debe mostrar:

- Una tabla HTML con los usuarios válidos
- Un mensaje de error controlado para el correo inválido