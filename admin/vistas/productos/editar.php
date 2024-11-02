<?php
require_once "../../../includes/database.php";
require_once "../../../includes/header.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $conexion = conectarBaseDatos();
        $sql = "SELECT * FROM productos WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$producto) {
            die('<div class="alert alert-danger">Producto no encontrado.</div>');
        }
    } catch (PDOException $e) {
        die('<div class="alert alert-danger">Error al obtener el producto: ' . $e->getMessage() . '</div>');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria_id = $_POST['categoria_id'];

    try {
        $conexion = conectarBaseDatos();
        $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, 
                precio = :precio, stock = :stock, categoria_id = :categoria_id WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':stock' => $stock,
            ':categoria_id' => $categoria_id
        ]);
        echo '<div class="alert alert-success">Producto actualizado exitosamente.</div>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error al actualizar el producto: ' . $e->getMessage() . '</div>';
    }
}
?>


<div class="container mt-5">
        <h1 class="text-center mb-4">Editar Producto</h1>
        <?php if (isset($producto)): ?>
            <form method="POST" action="editar.php" class="shadow p-4 rounded bg-light">
                <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id']) ?>">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" id="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" id="descripcion" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" name="precio" class="form-control" id="precio" value="<?= htmlspecialchars($producto['precio']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" id="stock" value="<?= htmlspecialchars($producto['stock']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="categoria_id" class="form-label">Categoría ID</label>
                    <input type="number" name="categoria_id" class="form-control" id="categoria_id" value="<?= htmlspecialchars($producto['categoria_id']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Actualizar Producto</button>
            </form>
        <?php else: ?>
            <p class="text-danger">ID de producto inválido.</p>
        <?php endif; ?>
    </div>
</body>
</html>