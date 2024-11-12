<?php
require_once "../../../includes/database.php";
require_once "../../../includes/header.php";
require_once "../../../includes/funciones.php";

try {
    $conexion = conectarBaseDatos();
    $sqlClientes = "SELECT id, nombre FROM clientes";
    $stmtClientes = $conexion->query($sqlClientes);
    $clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);

    // Obtener productos con stock disponible
    $sqlProductos = "SELECT id, nombre FROM productos WHERE stock > 0";
    $stmtProductos = $conexion->query($sqlProductos);
    $productosDisponibles = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Error al obtener los clientes: ' . $e->getMessage() . '</div>';
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Consulta para obtener los datos del pedido con el nombre del cliente
        $sql = "SELECT pedidos.*, clientes.nombre AS cliente_nombre 
                FROM pedidos
                JOIN clientes ON pedidos.cliente_id = clientes.id
                WHERE pedidos.id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pedido) {
            die('<div class="alert alert-danger">Pedido no encontrado.</div>');
        }

        // Obtener productos actuales del pedido
        $sqlDetalles = "SELECT producto_id, cantidad FROM detalle_pedido WHERE pedido_id = :pedido_id";
        $stmtDetalles = $conexion->prepare($sqlDetalles);
        $stmtDetalles->execute([':pedido_id' => $id]);
        $productosPedido = $stmtDetalles->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die('<div class="alert alert-danger">Error al obtener el pedido: ' . $e->getMessage() . '</div>');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $cliente_id = $_POST['cliente_id'];
    $fecha_pedido = $_POST['fecha_pedido'];
    $medio_pago = $_POST['medio_pago'];
    $estado_pedido = $_POST['estado_pedido'];
    $productosPedido = $_POST['productos'] ?? [];

    try {
        $conexion = conectarBaseDatos();
        $sql = "UPDATE pedidos SET cliente_id = :cliente_id, fecha_pedido = :fecha_pedido, 
                medio_pago = :medio_pago, estado_pedido = :estado_pedido WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':cliente_id' => $cliente_id,
            ':fecha_pedido' => $fecha_pedido,
            ':medio_pago' => $medio_pago,
            ':estado_pedido' => $estado_pedido,
        ]);

         // Actualizar productos del pedido en detalle_pedido
        // Primero, eliminar todos los productos actuales del pedido
        $sqlDeleteDetalles = "DELETE FROM detalle_pedido WHERE pedido_id = :pedido_id";
        $stmtDelete = $conexion->prepare($sqlDeleteDetalles);
        $stmtDelete->execute([':pedido_id' => $id]);

         // Insertar los productos seleccionados en detalle_pedido
        foreach ($productosPedido as $producto) {
            $sqlDetalle = "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad) VALUES (:pedido_id, :producto_id, :cantidad)";
            $stmtDetalle = $conexion->prepare($sqlDetalle);
            $stmtDetalle->execute([
                ':pedido_id' => $id,
                ':producto_id' => $producto['producto_id'],
                ':cantidad' => $producto['cantidad']
            ]);
        }

        header("refresh:2;url=../../pedidos.php");
        echo '<div class="alert alert-success align-items-center">pedido actualizado exitosamente.</div>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error al actualizar el pedido: ' . $e->getMessage() . '</div>';
    }
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Editar pedido</h1>
    <?= include "../../../includes/atras.php"; ?>
    <?php if (isset($pedido)): ?>
        <div class="row">
            <form method="POST" action="editar.php" class="shadow p-4 rounded bg-dark col-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">
                <input type="hidden" name="id" value="<?= htmlspecialchars($pedido['id']) ?>">

                <!-- Campo Cliente -->
                <div class="mb-3">
                    <label for="cliente_id" class="form-label text-light">Cliente</label>
                    <select name="cliente_id" class="form-select" id="cliente_id" disabled>
                        <option value="">Selecciona un cliente</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= htmlspecialchars($cliente['id']) ?>" 
                                <?= $cliente['id'] == $pedido['cliente_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cliente['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select> 
                    <input type="hidden" name="cliente_id" value="<?= htmlspecialchars($pedido['cliente_id']) ?>">
                </div>

                <!-- Campo Estado Pedido -->
                <div class="mb-3">
                    <label for="estado_pedido" class="form-label text-light">Estado</label>
                    <select name="estado_pedido" class="form-select" id="estado_pedido" required>
                        <option value="Pendiente" <?= $pedido['estado_pedido'] == "Pendiente" ? 'selected' : '' ?>>Pendiente</option>
                        <option value="Preparado" <?= $pedido['estado_pedido'] == "Preparado" ? 'selected' : '' ?>>Preparado</option>
                        <option value="Entregado" <?= $pedido['estado_pedido'] == "Entregado" ? 'selected' : '' ?>>Entregado</option>
                    </select>
                </div>

                <div class="row">
                    <!-- Campo Medio de Pago -->
                    <div class="mb-3 col">
                        <label for="medio_pago" class="form-label text-light">Medio de pago</label>
                        <select name="medio_pago" class="form-select" id="medio_pago" disabled>
                            <option value="Tarjeta" <?= $pedido['medio_pago'] == "Tarjeta" ? 'selected' : '' ?>>Tarjeta</option>
                            <option value="Efectivo" <?= $pedido['medio_pago'] == "Efectivo" ? 'selected' : '' ?>>Efectivo</option>
                        </select>
                        <input type="hidden" name="medio_pago" value="<?= htmlspecialchars($pedido['medio_pago']) ?>">
                    </div>

                    <!-- Campo Fecha Pedido -->
                    <div class="mb-3 col">
                        <label for="fecha_pedido" class="form-label text-light">Fecha pedido</label>
                        <input type="datetime-local" name="fecha_pedido" class="form-control" id="fecha_pedido" 
                            value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($pedido['fecha_pedido']))) ?>" readonly>
                    </div>
                </div>
                
                <div class="row px-2">
                    <!-- Sección de Productos en el Pedido -->
                    <h4 class="text-light col-9 mx-0 px-0">Agregar Productos al Pedido</h4>
                    <!-- Botón para agregar una nueva fila de productos -->
                    <button type="button" class="btn btn-success mb-3 offset-2 col-1" id="add-producto">+</button>
                </div>

                <div id="productos-container">
                    <?php foreach ($productosPedido as $index => $producto): ?>
                        <div class="row mb-3 producto-row">
                            <div class="col">
                                <!-- <label class="form-label text-light">Producto</label> -->
                                <select name="productos[<?= $index ?>][producto_id]" class="form-select">
                                    <?php foreach ($productosDisponibles as $productoDisponible): ?>
                                        <option value="<?= htmlspecialchars($productoDisponible['id']) ?>" 
                                            <?= $productoDisponible['id'] == $producto['producto_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($productoDisponible['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col">
                                <!-- <label class="form-label text-light">Cantidad</label> -->
                                <input type="number" name="productos[<?= $index ?>][cantidad]" class="form-control" 
                                    value="<?= htmlspecialchars($producto['cantidad']) ?>" required>
                            </div>
                            <div class="col-auto align-self-end">
                                <button type="button" class="btn btn-danger remove-producto">-</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <a href="../../pedidos.php"><button type="submit" class="btn btn-success w-100">Actualizar</button></a>
            </form>
        </div>
    <?php endif; ?>
</div>

<script>
// Script para agregar y eliminar productos en el formulario
document.addEventListener('DOMContentLoaded', function() {
    let contador = <?= count($productosPedido) ?>;

    // Evento para agregar una nueva fila de producto
    document.getElementById('add-producto').addEventListener('click', function() {
        const container = document.getElementById('productos-container');
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-3', 'producto-row');
        newRow.innerHTML = `
            <div class="col">
                <select name="productos[${contador}][producto_id]" class="form-select" required>
                    <?php foreach ($productosDisponibles as $productoDisponible): ?>
                        <option value="<?= htmlspecialchars($productoDisponible['id']) ?>"><?= htmlspecialchars($productoDisponible['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col">
                <input type="number" name="productos[${contador}][cantidad]" class="form-control" min="1" required>
            </div>
            <div class="col-auto align-self-end">
                <button type="button" class="btn btn-danger remove-producto">-</button>
            </div>
        `;
        container.appendChild(newRow);
        contador++;

        // Evento para eliminar la fila de producto
        newRow.querySelector('.remove-producto').addEventListener('click', function() {
            newRow.remove();
        });
    });

    // Evento para eliminar fila de producto
    document.querySelectorAll('.remove-producto').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.producto-row').remove();
        });
    });
});
</script>

<?php
require_once "../../../includes/footer.php";
?>
