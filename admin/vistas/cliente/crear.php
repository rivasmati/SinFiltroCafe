<?php
require_once "../../../includes/database.php";
require_once "../../../includes/header.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $fecha_registro = $_POST['fecha_registro'];

    try {
        $conexion = conectarBaseDatos();
        $sql = "INSERT INTO clientes (nombre, email, telefono, fecha_registro) 
                VALUES (:nombre, :email, :telefono, :fecha_registro)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':telefono' => $telefono,
            ':fecha_registro' => $fecha_registro,
        ]);

        echo '<div class="alert alert-success">Cliente creado exitosamente.</div>';
        echo '<script>setTimeout(() => { window.location.href = "../../clientes.php"; }, 1500);</script>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error al crear el cliente: ' . $e->getMessage() . '</div>';
    }
}
?>

    <div class="container mt-5">
    <h1 class="text-center mb-4">Crear cliente</h1>
    <?= include "../../../includes/atras.php"; ?>
        <div class="row">
            <form method="POST" action="crear.php" class="shadow p-4 rounded bg-dark col-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">
                <div class="mb-3">
                    <label for="nombre" class="form-label text-light">Nombre</label>
                    <input type="text" name="nombre" class="form-control" id="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-light">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>

                <div class="row">
                    <div class="mb-3 col">
                        <label for="telefono" class="form-label text-light">Telefono</label>
                        <input type="tel" name="telefono" class="form-control" id="telefono" required>
                    </div>

                    <div class="mb-3 col">
                        <label for="fecha_registro" class="form-label text-light">Fecha Registro</label>
                        <input type="date" name="fecha_registro" class="form-control" id="fecha_registro" required>
                    </div>
                </div>
                <a href="../../index.php">
                    <button type="submit" class="btn btn-primary w-100">Crear Cliente</button>
                </a>
            </form>
        </div>
    </div>
    
<?php
require_once "../../../includes/footer.php";
?>
