<?php
require_once "../../../includes/database.php";
require_once "../../../includes/header.php";
require_once "../../../includes/funciones.php";

try {
    $conexion = conectarBaseDatos();
    $sqlClientes = "SELECT id, nombre FROM clientes";
    $stmtClientes = $conexion->query($sqlClientes);
    $clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);
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
        echo '<div class="alert alert-success align-items-center">pedido actualizado exitosamente.</div>';
        header("refresh:2;url=../../pedidos.php");
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
                    <select name="cliente_id" class="form-select" id="cliente_id" required>
                        <option value="">Selecciona un cliente</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= htmlspecialchars($cliente['id']) ?>" 
                                <?= $cliente['id'] == $pedido['cliente_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cliente['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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
                        <select name="medio_pago" class="form-select" id="medio_pago" required>
                            <option value="Tarjeta" <?= $pedido['medio_pago'] == "Tarjeta" ? 'selected' : '' ?>>Tarjeta</option>
                            <option value="Efectivo" <?= $pedido['medio_pago'] == "Efectivo" ? 'selected' : '' ?>>Efectivo</option>
                        </select>
                    </div>

                    <!-- Campo Fecha Pedido -->
                    <div class="mb-3 col">
                        <label for="fecha_pedido" class="form-label text-light">Fecha pedido</label>
                        <input type="datetime-local" name="fecha_pedido" class="form-control" id="fecha_pedido" 
                            value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($pedido['fecha_pedido']))) ?>" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100">Actualizar</button>
            </form>
        </div>
    <?php else: ?>
        <p class="text-danger">ID de pedido inválido.</p>
    <?php endif; ?>
</div>
</body>
</html>