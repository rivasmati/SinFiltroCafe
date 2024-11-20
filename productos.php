<?php
require_once "includes/database.php";
require_once "includes/header.php";
require "includes/funciones.php";

$conexion = conectarBaseDatos();
$productosDisponibles = obtenerProductosConStock();

try {
    $sqlClientes = "SELECT id, nombre, email, telefono FROM clientes";
    $stmtClientes = $conexion->query($sqlClientes);
    $clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Error al obtener los clientes: ' . $e->getMessage() . '</div>';
}

?>

<main>
    <div class="container mt-5">
      <h1 class="p-3">Nuestros productos</h1>
      <div class="row row-cols-2 row-cols-lg-4 row-cols-md-3 mb-4" id="product-list"></div>
      <form action="./admin/vistas/pedido/crear.php?origen=pedido" method="POST" class="row row-cols-2 bg-dark rounded p-3"> 
        <!-- Campo Email con datalist -->
        <div class="col">
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
          <div class="row row-cols-2">
            <div class="mb-3 col">
                <label for="telefono" class="form-label text-light">Teléfono</label>
                <input type="text" name="telefono" class="form-control" id="telefono" required>
            </div>
            <div class="col">
              <label for="medio_pago" class="form-label text-light">Medio de pago</label>
              <select name="medio_pago" class="form-select" id="medio_pago" required>
                  <option value="Tarjeta">Tarjeta</option>
                  <option value="Efectivo">Efectivo</option>
              </select>
            </div>
          </div>
          <input type="hidden" name="fecha_pedido" class="form-control" id="fecha_pedido" value="<?= date('Y-m-d\TH:i') ?>" required>
          <input type="hidden" name="estado_pedido" id="estado_pedido" value="Pendiente" required>
        </div>
        <div id="smartcart" class="align-items-start col text-light"></div>
      </form>
    </div>
</main>

<!-- JQuery -->
<script src="vendors/jquery-3.7.1.min.js"></script>
<!-- SmartCart -->
<script src="vendors/jquery.smartcart/dist/js/jquery.smartCart.min.js"></script>
<script src="./js/productos.js"></script>

<?php require_once "includes/footer.php"; ?>

<script>
  
  document.getElementById('fecha_pedido').value = new Date().toISOString().slice(0, 16);
  
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