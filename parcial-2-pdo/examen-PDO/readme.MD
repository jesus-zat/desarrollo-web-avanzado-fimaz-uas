# Examen Práctico: Uso de PDO y Transacciones en PHP

## Descripción

El presente proyecto consiste en el desarrollo de una aplicación en PHP que permite el registro de alumnos en una base de datos MySQL. Para la conexión se utiliza PDO, incorporando el uso de transacciones y manejo de excepciones con el objetivo de garantizar la integridad de los datos.

## Objetivo

Aplicar buenas prácticas en el manejo de bases de datos mediante:

- Conexión a MySQL utilizando PDO  
- Implementación de transacciones (COMMIT y ROLLBACK)  
- Manejo de errores con estructuras try/catch  
- Validación de datos y uso de restricciones como campos únicos (correo)

## Funcionamiento

El sistema permite registrar la información de un alumno (nombre, apellido y correo).  
Al realizar el registro, los datos se insertan en la base de datos y se genera un registro adicional (log) de la operación.

En caso de que ocurra un error durante el proceso, la transacción es revertida automáticamente, evitando que se almacenen datos incompletos o inconsistentes.

## Pruebas realizadas

- Registro correcto: la información se almacena exitosamente mediante COMMIT.  
- Simulación de error: la operación es cancelada utilizando ROLLBACK, evitando el guardado de datos.