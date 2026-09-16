# Sin Filtro Café

Proyecto académico (Tercer Cuatrimestre) de una cafetería con catálogo de productos, carrito de pedidos y un panel de administración (CRUD) para productos, pedidos y clientes.

Sitio en vivo: https://rivasmati.com/sinFiltroCafe/

## Stack

PHP con PDO y MySQL, Bootstrap 5, jQuery y el plugin jquery.smartcart para el carrito.

## Probar el panel de administración

El panel es de demostración: podés usarlo libremente para ver cómo funciona el CRUD de productos, pedidos y clientes. No maneja datos reales ni información sensible.

URL: https://rivasmati.com/sinFiltroCafe/admin/login.php

Usuario: `admin`
Contraseña: `admin`

También existe un segundo usuario: `user` / `123456`.

## Instalación local

Ver [guia-instalacion.md](guia-instalacion.md) para levantar la base de datos en un entorno local (XAMPP). Después de importar `cafeteria.sql`, copiá `includes/config.example.php` como `includes/config.php` y completá tus credenciales de MySQL local.
