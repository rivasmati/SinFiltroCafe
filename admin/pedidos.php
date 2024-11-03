<?php
require_once "../includes/header.php";
require_once "../includes/database.php";
require "../includes/funciones.php";

$pedidos = listarPedidos();

    echo '
    <body class="bg-light">
        <div class="container mt-5">
            <h1 class="text-center my-4 pt-3">Listado de Pedidos</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Fecha pedido</th>
                            <th>Medio de pago</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>';
                    if (count($pedidos) > 0):
                        echo "<a href='./vistas/pedidos/crear.php' class='btn btn-success mb-3'>Agregar Nuevo Pedido</a><br>";
                        foreach ($pedidos as $pedido):
                            echo "<tr>
                                <td>" . htmlspecialchars($pedido["id"]) . "</td>
                                <td>" . htmlspecialchars($pedido["cliente_nombre"]) . "</td>
                                <td>" . htmlspecialchars($pedido["fecha_pedido"]) . "</td>
                                <td>" . htmlspecialchars($pedido["medio_pago"]) . "</td>
                                <td>" . htmlspecialchars($pedido["estado_pedido"]) . "</td>
                                <td>
                                    <a href='./vistas/pedidos/editar.php?id=" . htmlspecialchars($pedido["id"]) . "' class='btn btn-primary'>Editar</a>
                                    <form method='POST' action='./vistas/pedidos/borrar.php' class='d-inline'>
                                        <input type='hidden' name='id' value='" . htmlspecialchars($pedido["id"]) . "'>
                                        <button type='submit' class='btn btn-danger'>Eliminar</button>
                                    </form>
                                </td>
                            </tr>";
                        endforeach;
                    else:
                        echo '<tr>
                            <td colspan="5" class="text-center">No se encontraron pedidos.</td>
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