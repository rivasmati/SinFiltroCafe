<?php
require_once "../../../includes/database.php";
require_once "../../../includes/header.php";
require_once "../../../includes/funciones.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $conexion = conectarBaseDatos();
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cliente) {
            die('<div class="alert alert-danger">Cliente no encontrado.</div>');
        }
    } catch (PDOException $e) {
        die('<div class="alert alert-danger">Error al obtener el cliente: ' . $e->getMessage() . '</div>');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $fecha_registro = $_POST['fecha_registro'];

    try {
        $conexion = conectarBaseDatos();
        $sql = "UPDATE clientes SET nombre = :nombre, email = :email, 
                telefono = :telefono, fecha_registro = :fecha_registro WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':email' => $email,
            ':telefono' => $telefono,
            ':fecha_registro' => $fecha_registro,
        ]);
        header("refresh:2;url=../../clientes.php");
        echo '<div class="alert alert-success align-items-center">Cliente actualizado exitosamente.</div>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error al actualizar el cliente: ' . $e->getMessage() . '</div>';
    }
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Editar cliente</h1>
    <?= include "../../../includes/atras.php"; ?>
    <?php if (isset($cliente)): ?>
        <div class="row">
            <form method="POST" action="editar.php" class="shadow p-4 rounded bg-dark col-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">
                <input type="hidden" name="id" value="<?= htmlspecialchars($cliente['id']) ?>">
                <div class="mb-3">
                    <label for="nombre" class="form-label text-light">Nombre</label>
                    <input type="text" name="nombre" class="form-control" id="nombre"
                        value="<?= htmlspecialchars($cliente['nombre']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-light">Email</label>
                    <input type="text" name="email" class="form-control" id="email" value="<?= htmlspecialchars($cliente['email']) ?>" required>
                </div>

                <div class="row">
                    <div class="mb-3 col">
                        <label for="telefono" class="form-label text-light">Telefono</label>
                        <input type="tel" name="telefono" class="form-control" id="telefono"
                            value="<?= htmlspecialchars($cliente['telefono']) ?>" required>
                    </div>

                    <div class="mb-3 col">
                        <label for="fecha_registro" class="form-label text-light">Fecha Registro</label>
                        <input type="date" name="fecha_registro" class="form-control" id="fecha_registro"
                            value="<?= htmlspecialchars($cliente['fecha_registro']) ?>" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100">Actualizar</button>
            </form>
        </div>
    <?php else: ?>
        <p class="text-danger">ID de cliente inválido.</p>
    <?php endif; ?>
</div>

<?php
require_once "../../../includes/footer.php";
?>