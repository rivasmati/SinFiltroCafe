<?php
require_once "../../../includes/database.php";
require_once "../../../includes/header.php";
require_once "../../../includes/funciones.php";

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
        echo '<div class="alert alert-success align-items-center">Producto actualizado exitosamente.</div>';
        header("refresh:2;url=../../index.php");
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error al actualizar el producto: ' . $e->getMessage() . '</div>';
    }
}
?>

<?php 
    if ($producto['categoria_id'] == 1) {
        $categoria = "Café";
    }elseif ($producto['categoria_id'] == 2) {
        $categoria = "Bebida";
    }elseif ($producto['categoria_id'] == 3) {
        $categoria = "Dulce";
    }elseif ($producto['categoria_id'] == 4) {
        $categoria = "Salado";
    }         
?> 

<div class="container mt-5">
    <h1 class="text-center mb-4">Editar producto</h1>
    <?php if (isset($producto)): ?>
        <div class="row">
            <form method="POST" action="editar.php" class="shadow p-4 rounded bg-dark col-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">
                <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id']) ?>">
                <div class="mb-3">
                    <label for="nombre" class="form-label text-light">Nombre</label>
                    <input type="text" name="nombre" class="form-control" id="nombre"
                        value="<?= htmlspecialchars($producto['nombre']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label text-light">Descripción</label>
                    <textarea name="descripcion" class="form-control" id="descripcion"
                        required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
                </div>

                <div class="row">
                    <div class="mb-3 col">
                        <label for="precio" class="form-label text-light">Precio</label>
                        <input type="number" name="precio" class="form-control" id="precio"
                            value="<?= htmlspecialchars($producto['precio']) ?>" required>
                    </div>

                    <div class="mb-3 col">
                        <label for="stock" class="form-label text-light">Stock</label>
                        <input type="number" name="stock" class="form-control" id="stock"
                            value="<?= htmlspecialchars($producto['stock']) ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="categoria_id" class="form-label text-light">Categoría</label>
                    <select class="form-select" aria-label="Default select example" id="categoria_id" name="categoria_id">
                        <option value="1" <?= $categoria == 1 ? 'selected' : '' ?>>Café</option>
                        <option value="2" <?= $categoria == 2 ? 'selected' : '' ?>>Bebida</option>
                        <option value="3" <?= $categoria == 3 ? 'selected' : '' ?>>Dulce</option>
                        <option value="4" <?= $categoria == 4 ? 'selected' : '' ?>>Salado</option>
                    </select required>
                </div>
                <button type="submit" class="btn btn-success w-100">Actualizar</button>
            </form>
        </div>
    <?php else: ?>
        <p class="text-danger">ID de producto inválido.</p>
    <?php endif; ?>
</div>

<?php
require_once "../../../includes/footer.php";
?>