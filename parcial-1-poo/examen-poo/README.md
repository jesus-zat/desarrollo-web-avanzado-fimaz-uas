# Documentacion

## Descripción
- Este proyecto implementa un mini sistema de usuarios utilizando Programación Orientada a Objetos en PHP.
- Se utilizan clases, herencia, validación de datos y manejo de excepciones para simular un sistema básico de usuarios.

## Funcionamiento del index.php
- Se importan las clases Admin y Alumno.
- Se crea un arreglo llamado usuarios para almacenar los objetos creados.
- Se utiliza un bloque try/catch para manejar posibles errores.
- Se crean:
- Un Admin válido
- Un Alumno válido
- Un usuario con correo inválido para probar la excepción
- Si ocurre un error se muestra un mensaje de error controlado.

## Salida del sistema
- Los usuarios válidos se recorren con un foreach.
- Los datos se muestran en una tabla HTML con las columnas:
- Nombre
- Correo
- Rol
- Matrícula
- La matrícula solo se muestra cuando el usuario es de tipo Alumno.

## Tecnologías utilizadas
- PHP 8
- Programación Orientada a Objetos
- HTML básico
- XAMPP