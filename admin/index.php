<?php
require_once "../includes/header.php";
require_once "../includes/database.php";
require "../includes/funciones.php";

$productos = listarProductos();
$clientes = listarClientes();

    echo '
    <body class="bg-light">
        <section class="container mt-5 pt-3 text-center">
            <h1 class="h1 mb-5">¡Bienvenido al panel de administración!</h1>
            <div class="row g-4">
            <!-- Tarjeta 1 -->
            <div class="col-md-4">
                <a href="./productos.php" class="text-decoration-none">
                    <div class="card bg-dark text-white">
                        <img src="../img/admin/productos.webp" class="card-img" alt="Imagen 1">
                        <div class="card-img-overlay d-flex align-items-center justify-content-center">
                            <h2 class="card-title text-center bg-dark bg-opacity-75 p-2 rounded">Productos</h2>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tarjeta 2 -->
            <div class="col-md-4">
                <a href="./pedidos.php" class="text-decoration-none">
                    <div class="card bg-dark text-white">
                        <img src="../img/admin/pedidos.jpg" class="card-img" alt="Imagen 2">
                        <div class="card-img-overlay d-flex align-items-center justify-content-center">
                            <h2 class="card-title text-center bg-dark bg-opacity-75 p-2 rounded">Pedidos</h2>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tarjeta 3 -->
            <div class="col-md-4">
                <a href="./clientes.php" class="text-decoration-none">
                    <div class="card bg-dark text-white">
                        <img src="../img/admin/clientes.jpg" class="card-img" alt="Imagen 3">
                        <div class="card-img-overlay d-flex align-items-center justify-content-center">
                            <h2 class="card-title text-center bg-dark bg-opacity-75 p-2 rounded">Clientes</h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        </section>';

require_once "../includes/footer.php";

?>