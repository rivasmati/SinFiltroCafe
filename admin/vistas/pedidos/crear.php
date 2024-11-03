<?php
require_once "../../../includes/database.php";
require_once "../../../includes/header.php";

$conexion = conectarBaseDatos();

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
        echo '<div class="alert alert-success">Pedido creado exitosamente.</div>';
        header("refresh:2;url=../../pedidos.php");

    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error al crear el pedido: ' . $e->getMessage() . '</div>';
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
                <a href="../../index.php">
                    <button type="submit" class="btn btn-primary w-100">Crear pedido</button>
                </a>
            </form>
        </div>
    </div>

<script>
    // Configurar el campo de fecha para que tenga la fecha y hora actual
    document.getElementById('fecha_pedido').value = new Date().toISOString().slice(0, 16);
</script>
</body>
</html>
