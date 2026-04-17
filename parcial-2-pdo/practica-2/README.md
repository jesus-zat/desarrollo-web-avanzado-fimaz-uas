# Práctica 2: Uso de PDO con Transacciones en PHP

## Descripción

Esta práctica consiste en desarrollar un sistema sencillo en PHP que permite registrar alumnos en una base de datos MySQL utilizando PDO. Se implementa el uso de **transacciones**, **try/catch** y validaciones básicas para garantizar la integridad de los datos.

## Finalidad

El objetivo es comprender cómo manejar operaciones seguras en bases de datos, aplicando:

* Conexión a MySQL con PDO
* Uso de transacciones (`BEGIN`, `COMMIT`, `ROLLBACK`)
* Manejo de errores con `try/catch`
* Restricciones como `UNIQUE` en el campo correo

## Funcionamiento

* Se registra un alumno (nombre, apellido, correo)
* Se guarda un log de la acción
* Si ocurre un error (o se simula), se revierte toda la operación

## Prueba

* Registro normal → se guarda correctamente (COMMIT)
* Con "simular error" → no se guarda nada (ROLLBACK)

