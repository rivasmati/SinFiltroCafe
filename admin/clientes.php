<?php
require_once "../includes/header.php";
require_once "../includes/database.php";
require "../includes/funciones.php";

$clientes = listarClientes();

    echo '
    <body class="bg-light">
        <div class="container mt-5">
            <h1 class="text-center my-4 pt-3">Listado de Clientes</h1>
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
                        foreach ($clientes as $cliente):
                            echo "<tr>
                                <td>" . htmlspecialchars($cliente["id"]) . "</td>
                                <td>" . htmlspecialchars($cliente["nombre"]) . "</td>
                                <td>" . htmlspecialchars($cliente["email"]) . "</td>
                                <td>" . htmlspecialchars($cliente["telefono"]) . "</td>
                                <td>" . htmlspecialchars($cliente["fecha_registro"]) . "</td>
                                <td>
                                    <a href='./vistas/clientes/editar.php?id=" . htmlspecialchars($cliente["id"]) . "' class='btn btn-primary'>Editar</a>
                                    <form method='POST' action='./vistas/clientes/borrar.php' class='d-inline'>
                                        <input type='hidden' name='id' value='" . htmlspecialchars($cliente["id"]) . "'>
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