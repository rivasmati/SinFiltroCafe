<?php
require_once "../../../includes/database.php";
require_once "../../../includes/header.php";
require_once "../../../includes/funciones.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $conexion = conectarBaseDatos();
        $sql = "SELECT * FROM pedidos WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pedido) {
            die('<div class="alert alert-danger">pedido no encontrado.</div>');
        }
    } catch (PDOException $e) {
        die('<div class="alert alert-danger">Error al obtener el pedido: ' . $e->getMessage() . '</div>');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $pedido = $_POST['pedido'];
    $fecha_pedido = $_POST['fecha_pedido'];
    $medio_pago = $_POST['medio_pago'];
    $estado_pedido = $_POST['estado_pedido'];

    try {
        $conexion = conectarBaseDatos();
        $sql = "UPDATE pedidos SET pedido = :pedido, fecha_pedido = :fecha_pedido, 
                medio_pago = :medio_pago, estado_pedido = :estado_pedido WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':pedido' => $pedido,
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
                <div class="mb-3">
                    <label for="cliente_id" class="form-label text-light">Cliente</label>
                    <input type="text" name="cliente_id" class="form-control" id="cliente_id"
                        value="<?= htmlspecialchars($pedido['cliente_id']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="estado_pedido" class="form-label text-light">Estado</label>
                    <input type="text" name="estado_pedido" class="form-control" id="estado_pedido"
                        value="<?= htmlspecialchars($pedido['estado_pedido']) ?>" required>
                </div>

                <div class="row">
                    <div class="mb-3 col">
                        <label for="medio_pago" class="form-label text-light">Medio de pago</label>
                        <input type="tel" name="medio_pago" class="form-control" id="medio_pago"
                            value="<?= htmlspecialchars($pedido['medio_pago']) ?>" required>
                    </div>

                    <div class="mb-3 col">
                        
                        <label for="fecha_pedido" class="form-label text-light">Fechapedido</label>
                        <input type="datetime-local" name="fecha_pedido" class="form-control" id="fecha_pedido" value="<?= htmlspecialchars($pedido['fecha_pedido']) ?>" required>
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