<?php
require_once "../../../includes/database.php";
require_once "../../../includes/header.php";
require_once "../../../includes/funciones.php";

$conexion = conectarBaseDatos();
$productosDisponibles = obtenerProductosConStock();

try {
    $sqlClientes = "SELECT id, nombre, email, telefono FROM clientes";
    $stmtClientes = $conexion->query($sqlClientes);
    $clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Error al obtener los clientes: ' . $e->getMessage() . '</div>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $cliente_id = null;

    try {
        // Verificar si el cliente ya existe en la base de datos por su email
        $sqlVerificarCliente = "SELECT id FROM clientes WHERE email = :email";
        $stmtVerificarCliente = $conexion->prepare($sqlVerificarCliente);
        $stmtVerificarCliente->execute([':email' => $email]);
        $clienteExistente = $stmtVerificarCliente->fetch(PDO::FETCH_ASSOC);

        if ($clienteExistente) {
            // Si el cliente existe, usar su ID
            $cliente_id = $clienteExistente['id'];
        } else {
            // Si el cliente no existe, insertarlo en la tabla clientes
            $sqlInsertarCliente = "INSERT INTO clientes (nombre, email, telefono, fecha_registro) VALUES (:nombre, :email, :telefono, NOW())";
            $stmtInsertarCliente = $conexion->prepare($sqlInsertarCliente);
            $stmtInsertarCliente->execute([
                ':nombre' => $nombre,
                ':email' => $email,
                ':telefono' => $telefono,
            ]);
            $cliente_id = $conexion->lastInsertId();
        }

        // Código para crear el pedido utilizando $cliente_id
        $fecha_pedido = $_POST['fecha_pedido'];
        $medio_pago = $_POST['medio_pago'];
        $estado_pedido = $_POST['estado_pedido'];
        $productosPedido = $_POST['productos'] ?? [];  // Array de productos con sus cantidades

        $sqlPedido = "INSERT INTO pedidos (cliente_id, fecha_pedido, medio_pago, estado_pedido) 
                      VALUES (:cliente_id, :fecha_pedido, :medio_pago, :estado_pedido)";
        $stmtPedido = $conexion->prepare($sqlPedido);
        $stmtPedido->execute([
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

        header("refresh:1.5;url=../../pedidos.php");
    } catch (PDOException $e) {

    }
}    

?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Crear pedido</h1>
    <?= include "../../../includes/atras.php"; ?>
        <div class="row">
            <form method="POST" action="crear.php" class="shadow p-4 rounded bg-dark col-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">
                
                <!-- Campo Email con datalist -->
                <div class="mb-3">
                    <label for="email" class="form-label text-light">Email del Cliente</label>
                    <input list="emailList" name="email" class="form-control" id="email" required>
                    <datalist id="emailList">
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= htmlspecialchars($cliente['email']) ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <!-- Campos Nombre y Teléfono, que se completarán automáticamente si el email existe -->
                <div class="mb-3">
                    <label for="nombre" class="form-label text-light">Nombre</label>
                    <input type="text" name="nombre" class="form-control" id="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label text-light">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" id="telefono" required>
                </div>

                <!-- Resto del formulario (estado del pedido, medio de pago, fecha del pedido, etc.) -->
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

<?php
require_once "../../../includes/footer.php";
?>

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
    
    document.addEventListener('DOMContentLoaded', function() {
        const clientes = <?= json_encode($clientes); ?>; // Pasar los clientes como JSON al script
        const emailInput = document.getElementById('email');
        const nombreInput = document.getElementById('nombre');
        const telefonoInput = document.getElementById('telefono');

        // Escuchar el cambio en el campo de email
        emailInput.addEventListener('input', function() {
            const emailSeleccionado = emailInput.value;
            const cliente = clientes.find(c => c.email === emailSeleccionado);

            if (cliente) {
                // Si el cliente existe, completar los campos de nombre y teléfono
                nombreInput.value = cliente.nombre;
                telefonoInput.value = cliente.telefono;
            } else {
                // Si el cliente no existe, limpiar los campos de nombre y teléfono
                nombreInput.value = '';
                telefonoInput.value = '';
            }
        });
    });
</script>
