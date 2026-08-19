# CRUD de Productos (PHP + PDO + POO)

Sistema web desarrollado en **PHP**, **PDO** y **POO** para la gestión dinámica de un catálogo de productos con base de datos **MySQL**.

---

## ⚡ Funcionalidad del Sistema

- **Búsqueda Dinámica**: Filtra productos por nombre o descripción mediante el método `GET`. Si la búsqueda está vacía, muestra la lista completa de productos. Incluye un botón para restablecer la vista.
- **Creación de Productos**: Permite registrar nuevos productos ingresando nombre, descripción, existencia y precio mediante consultas preparadas con PDO.
- **Edición de Productos**: Carga los datos existentes de un producto seleccionado directamente en el formulario para actualizar su información en la base de datos.
- **Eliminación Segura**: Permite remover productos del catálogo previa confirmación del usuario.
- **Seguridad**: Implementa sentencias preparadas en PDO para prevenir ataques de inyección SQL.