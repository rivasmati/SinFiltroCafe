<?php
require_once "../includes/header.php";
require_once "../includes/database.php";
require "../includes/funciones.php";

$productos = listarProductos();

    echo '
    <body class="bg-light">
        <div class="container mt-5">
            <h1 class="text-center my-4 pt-3">Listado de Productos</h1>
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
                            echo "<a href='./vistas/producto/crear.php' class='btn btn-success mb-3 radio-100 fw-bold'>+</a><br>";
                            foreach ($productos as $producto):
                                if ($producto['categoria_id'] == 1) {
                                    $categoria = "Café";
                                }elseif ($producto['categoria_id'] == 2) {
                                    $categoria = "Bebida";
                                }elseif ($producto['categoria_id'] == 3) {
                                    $categoria = "Dulce";
                                }elseif ($producto['categoria_id'] == 4) {
                                    $categoria = "Salado";
                                }
                                echo "<tr>
                                    <td>" . htmlspecialchars($producto["id"]) . "</td>
                                    <td>" . htmlspecialchars($producto["nombre"]) . "</td>
                                    <td>" . htmlspecialchars($producto["descripcion"]) . "</td>
                                    <td>" . htmlspecialchars($producto["precio"]) . "</td>
                                    <td>" . htmlspecialchars($producto["stock"]) . "</td>
                                    <td>" . htmlspecialchars($categoria) . "</td>
                                    <td>
                                        <a href='./vistas/producto/editar.php?id=" . htmlspecialchars($producto["id"]) . "' class='btn btn-primary'>Editar</a>
                                        <form method='POST' action='./vistas/producto/borrar.php' class='d-inline'>
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
    echo '
                    </tbody>
                </table>
            </div>
        </div>';


require_once "../includes/footer.php";
?>