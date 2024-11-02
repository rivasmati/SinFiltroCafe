<?php
require_once "../../../includes/database.php";
require_once "../../../includes/header.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria_id = $_POST['categoria_id'];

    try {
        $conexion = conectarBaseDatos();
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id) 
                VALUES (:nombre, :descripcion, :precio, :stock, :categoria_id)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':precio' => $precio,
            ':stock' => $stock,
            ':categoria_id' => $categoria_id
        ]);
        echo '<div class="alert alert-success">Producto creado exitosamente.</div>';
        header("refresh:2;url=../../index.php");

    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error al crear el producto: ' . $e->getMessage() . '</div>';
    }
}
?>


    <div class="container mt-5">
        <h1 class="text-center mb-4">Crear Producto</h1>
        <form method="POST" action="crear.php" class="shadow p-4 rounded bg-light">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre del producto" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" id="descripcion" placeholder="Descripción del producto" required></textarea>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" name="precio" class="form-control" id="precio" placeholder="Precio" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" id="stock" placeholder="Stock disponible" required>
            </div>
            <div class="mb-3">
                <label for="categoria_id" class="form-label">Categoría ID</label>
                <input type="number" name="categoria_id" class="form-control" id="categoria_id" placeholder="ID de la categoría" required>
            </div>
            <a href="../../index.php">
                <button type="submit" class="btn btn-primary w-100">Crear Producto</button>
            </a>
        </form>
    </div>
</body>
</html>
