<?php
require_once "../includes/header.php";
require_once "../includes/database.php";
require "../includes/funciones.php";

$productos = listarProductos();
$clientes = listarClientes();

    echo '
    <body class="bg-light">
        <div class="container mt-5">
            <h1 class="text-center mb-4">Listado de Productos</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Categoría ID</th>
                        </tr>
                    </thead>
                    <tbody>';
                        if (count($productos) > 0):
                            foreach ($productos as $producto):
                                echo "<tr>
                                    <td>" . htmlspecialchars($producto["id"]) . "</td>
                                    <td>" . htmlspecialchars($producto["nombre"]) . "</td>
                                    <td>" . htmlspecialchars($producto["descripcion"]) . "</td>
                                    <td>" . htmlspecialchars($producto["precio"]) . "</td>
                                    <td>" . htmlspecialchars($producto["stock"]) . "</td>
                                    <td>" . htmlspecialchars($producto["categoria_id"]) . "</td>
                                </tr>";
                            endforeach;
                        else:
                            echo '<tr>
                                <td colspan="6" class="text-center">No se encontraron productos.</td>
                            </tr>';
                        endif;

                    echo '<div class="container mt-5">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Teléfono</th>
                                        <th>Fecha registtro</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                    if (count($clientes) > 0):
                                        foreach ($clientes as $clientes):
                                            echo "<tr>
                                                <td>" . htmlspecialchars($clientes["id"]) . "</td>
                                                <td>" . htmlspecialchars($clientes["nombre"]) . "</td>
                                                <td>" . htmlspecialchars($clientes["email"]) . "</td>
                                                <td>" . htmlspecialchars($clientes["telefono"]) . "</td>
                                                <td>" . htmlspecialchars($clientes["fecha_registro"]) . "</td>
                                            </tr>";
                                        endforeach;
                                    else:
                                        echo '<tr>
                                            <td colspan="5" class="text-center">No se encontraron productos.</td>
                                        </tr>';
                                    endif;
    echo '
                    </tbody>
                </table>
            </div>
        </div>
        <footer>
        </footer>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </html>';
?>