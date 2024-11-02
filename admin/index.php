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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>';
                        if (count($productos) > 0):
                            echo "<a href='./vistas/productos/crear.php' class='btn btn-success mb-3 radio-100 fw-bold'>+</a><br>";
                            foreach ($productos as $producto):
                                echo "<tr>
                                    <td>" . htmlspecialchars($producto["id"]) . "</td>
                                    <td>" . htmlspecialchars($producto["nombre"]) . "</td>
                                    <td>" . htmlspecialchars($producto["descripcion"]) . "</td>
                                    <td>" . htmlspecialchars($producto["precio"]) . "</td>
                                    <td>" . htmlspecialchars($producto["stock"]) . "</td>
                                    <td>" . htmlspecialchars($producto["categoria_id"]) . "</td>
                                    <td>
                                        <a href='./vistas/productos/editar.php?id=" . htmlspecialchars($producto["id"]) . "' class='btn btn-primary'>Editar</a>
                                        <form method='POST' action='./vistas/productos/borrar.php' class='d-inline'>
                                            <input type='hidden' name='id' value='" . htmlspecialchars($producto["id"]) . "'>
                                            <button type='submit' class='btn btn-danger'>Eliminar</button>
                                        </form>
                                    </td>
                                </tr>";
                            endforeach;
                        else:
                            echo '<tr>
                                <td colspan="6" class="text-center">No se encontraron productos.</td>
                            </tr>';
                        endif;
                        echo '</tbody></table>';

                    echo '<div class="container mt-5">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Fecha registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                    if (count($clientes) > 0):
                                        echo "<a href='./vistas/clientes/crear.php' class='btn btn-success mb-3'>Agregar Nuevo Cliente</a><br>";
                                        foreach ($clientes as $clientes):
                                            echo "<tr>
                                                <td>" . htmlspecialchars($clientes["id"]) . "</td>
                                                <td>" . htmlspecialchars($clientes["nombre"]) . "</td>
                                                <td>" . htmlspecialchars($clientes["email"]) . "</td>
                                                <td>" . htmlspecialchars($clientes["telefono"]) . "</td>
                                                <td>" . htmlspecialchars($clientes["fecha_registro"]) . "</td>
                                                <td>
                                                    <a href='./vistas/clientes/editar.php?id=" . htmlspecialchars($clientes["id"]) . "' class='btn btn-primary'>Editar</a>
                                                    <form method='POST' action='./vistas/clientes/borrar.php' class='d-inline'>
                                                        <input type='hidden' name='id' value='" . htmlspecialchars($clientes["id"]) . "'>
                                                        <button type='submit' class='btn btn-danger'>Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>";
                                        endforeach;
                                    else:
                                        echo '<tr>
                                            <td colspan="5" class="text-center">No se encontraron clientes.</td>
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