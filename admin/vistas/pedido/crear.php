<?php
require_once "../../../includes/database.php";
require_once "../../../includes/header.php";
require_once "../../../includes/funciones.php";

$conexion = conectarBaseDatos();
$productosDisponibles = obtenerProductosConStock();

try {
    $sqlClientes = "SELECT id, nombre FROM clientes";
    $stmtClientes = $conexion->query($sqlClientes);
    $clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Error al obtener los clientes: ' . $e->getMessage() . '</div>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $fecha_pedido = $_POST['fecha_pedido'];
    $medio_pago = $_POST['medio_pago'];
    $estado_pedido = $_POST['estado_pedido'];
    $productosPedido = $_POST['productos'] ?? [];  // Array de productos con sus cantidades

    try {
        $sql = "INSERT INTO pedidos (cliente_id, fecha_pedido, medio_pago, estado_pedido) 
                VALUES (:cliente_id, :fecha_pedido, :medio_pago, :estado_pedido)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':cliente_id' => $cliente_id,
            ':fecha_pedido' => $fecha_pedido,
            ':medio_pago' => $medio_pago,
            ':estado_pedido' => $estado_pedido,
        ]);

        $pedidoId = $conexion->lastInsertId();

        // Insertar productos del pedido en detalle_pedido
        foreach ($productosPedido as $producto) {
            $sqlDetalle = "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad) VALUES (:pedido_id, :producto_id, :cantidad)";
            $stmtDetalle = $conexion->prepare($sqlDetalle);
            $stmtDetalle->execute([
                ':pedido_id' => $pedidoId,
                ':producto_id' => $producto['producto_id'],
                ':cantidad' => $producto['cantidad']
            ]);
        }

        header("refresh:2;url=../../pedidos.php");
        #include "../../../includes/toasts.php";
        #echo '<div class="alert alert-success">Pedido creado exitosamente.</div>';
        echo "<script>document.addEventListener('DOMContentLoaded', function() { var toastSuccess = new bootstrap.Toast(document.getElementById('toastSuccess')); toastSuccess.show(); });</script>";
    } catch (PDOException $e) {
        #echo '<div class="alert alert-danger">Error al crear el pedido: ' . $e->getMessage() . '</div>';
        echo "<script>document.addEventListener('DOMContentLoaded', function() { var toastError = new bootstrap.Toast(document.getElementById('toastError')); toastError.show(); });</script>";
    }
    

}
?>

    <div class="container mt-5">
    <h1 class="text-center mb-4">Crear pedido</h1>
    <?= include "../../../includes/atras.php"; ?>
        <div class="row">
            <form method="POST" action="crear.php" class="shadow p-4 rounded bg-dark col-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">
                <div class="mb-3">
                    <label for="cliente_id" class="form-label text-light">Cliente</label>
                    <select name="cliente_id" class="form-select" id="cliente_id" required>
                        <option value="">Selecciona un cliente</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= htmlspecialchars($cliente['id']) ?>">
                                <?= htmlspecialchars($cliente['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                </div>
                <div class="mb-3">
                    <label for="estado_pedido" class="form-label text-light">Estado</label>
                    <select name="estado_pedido" class="form-select" id="estado_pedido" required>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Preparado">Preparado</option>
                        <option value="Entregado">Entregado</option>
                    </select>                    
                </div>

                <div class="row">
                    <div class="mb-3 col">
                        <label for="medio_pago" class="form-label text-light">Medio de pago</label>
                        <select name="medio_pago" class="form-select" id="medio_pago" required>
                            <option value="Tarjeta">Tarjeta</option>
                            <option value="Efectivo">Efectivo</option>
                        </select>
                    </div>

                    <div class="mb-3 col">
                        <label for="fecha_pedido" class="form-label text-light">Fecha pedido</label>
                        <input type="datetime-local" name="fecha_pedido" class="form-control" id="fecha_pedido" 
                        value="<?= date('Y-m-d\TH:i') ?>" required>
                    </div>
                </div>

                <h4 class="text-light">Agregar Productos al Pedido</h4>
                    <div id="productos-container">
                        <div class="row mb-3 producto-row">
                            <div class="col">
                                <label for="producto" class="form-label text-light">Producto</label>
                                <select name="productos[0][producto_id]" class="form-select producto-select" required>
                                    <?php foreach ($productosDisponibles as $producto): ?>
                                        <option value="<?= htmlspecialchars($producto['id']) ?>"><?= htmlspecialchars($producto['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="cantidad" class="form-label text-light">Cantidad</label>
                                <input type="number" name="productos[0][cantidad]" class="form-control cantidad-input" min="1" required>
                            </div>
                            <div class="col-auto align-self-end">
                                <button type="button" class="btn btn-success add-producto">+</button>
                            </div>
                        </div>
                    </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Crear Pedido</button>
                <!--<a href="../../index.php"><button type="submit" class="btn btn-primary w-100">Crear pedido</button></a>-->
            </form>
        </div>
    </div>

<script>
    // Configurar el campo de fecha para que tenga la fecha y hora actual
    document.getElementById('fecha_pedido').value = new Date().toISOString().slice(0, 16);

    document.addEventListener('DOMContentLoaded', function() {
        let contador = 1; // Contador para índices de productos

        // Evento para agregar una nueva fila de producto
        document.querySelector('.add-producto').addEventListener('click', function() {
            const productoContainer = document.getElementById('productos-container');
            const newProductoRow = document.createElement('div');
            newProductoRow.classList.add('row', 'mb-3', 'producto-row');

            // HTML de la nueva fila de producto
            newProductoRow.innerHTML = `
                <div class="col">
                    <select name="productos[${contador}][producto_id]" class="form-select producto-select" required>
                        <?php foreach ($productosDisponibles as $producto): ?>
                            <option value="<?= htmlspecialchars($producto['id']) ?>"><?= htmlspecialchars($producto['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <input type="number" name="productos[${contador}][cantidad]" class="form-control cantidad-input" min="1" required>
                </div>
                <div class="col-auto align-self-end">
                    <button type="button" class="btn btn-danger remove-producto">-</button>
                </div>
            `;

            // Evento para eliminar la fila de producto
            newProductoRow.querySelector('.remove-producto').addEventListener('click', function() {
                newProductoRow.remove();
            });

            productoContainer.appendChild(newProductoRow);
            contador++;
        });
    });
</script>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
    <!-- Toast de Éxito -->
    <div id="toastSuccess" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Pedido creado exitosamente.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    <!-- Toast de Error -->
    <div id="toastError" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Error al crear el pedido: <?= htmlspecialchars($e->getMessage() ?? '') ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<?php
require_once "../../../includes/footer.php";
?>
