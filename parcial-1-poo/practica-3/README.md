# Documentacion

## Descripción del sistema
En esta práctica se desarrolló un sistema de usuarios utilizando Programación Orientada a Objetos en PHP.  
Se implementa una clase base Usuario y dos clases derivadas Admin y Alumno, utilizando herencia para reutilizar código.  
El sistema valida el formato del correo electrónico y utiliza excepciones para manejar errores cuando el correo no es válido.


## Flujo de clases
- Usuario: clase base que contiene los atributos nombre y correo, además de validar el correo electrónico. Si el formato es incorrecto, se lanza una excepción.  
- Admin: hereda de Usuario e implementa el método getRol() que devuelve Administrador.  
- Alumno: hereda de Usuario, agrega el atributo matricula e implementa getRol() que devuelve Alumno.

## Manejo de errores
En index.php se utilizan bloques try/catch para crear usuarios válidos e intentar crear uno con correo inválido.  
Cuando ocurre el error, la excepción es capturada y se muestra un mensaje de error controlado, evitando que el programa se detenga.

## Conclusión
La práctica permitió aplicar conceptos de POO en PHP, como herencia, validación de datos y manejo de excepciones, utilizando una estructura organizada de proyecto.
