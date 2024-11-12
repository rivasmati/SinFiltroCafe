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
        header("refresh:2;url=../../index.php");
        echo '<div class="alert alert-success">Producto creado exitosamente.</div>';

    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error al crear el producto: ' . $e->getMessage() . '</div>';
    }
}


?>

    <div class="container mt-5">
    <h1 class="text-center mb-4">Crear producto</h1>
    <?= include "../../../includes/atras.php"; ?>
        <div class="row">
            <form method="POST" action="crear.php" class="shadow p-4 rounded bg-dark col-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">
                <div class="mb-3">
                    <label for="nombre" class="form-label text-light">Nombre</label>
                    <input type="text" name="nombre" class="form-control" id="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label text-light">Descripción</label>
                    <textarea name="descripcion" class="form-control" id="descripcion" required></textarea>
                </div>

                <div class="row">
                    <div class="mb-3 col">
                        <label for="precio" class="form-label text-light">Precio</label>
                        <input type="number" name="precio" class="form-control" id="precio" required>
                    </div>

                    <div class="mb-3 col">
                        <label for="stock" class="form-label text-light">Stock</label>
                        <input type="number" name="stock" class="form-control" id="stock" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="categoria_id" class="form-label text-light">Categoría</label>
                    <select class="form-select" aria-label="Default select example" id="categoria_id" name="categoria_id">
                        <option selected>Seleccioná la categoría</option>
                        <option value="1">Café</option>
                        <option value="2">Bebida</option>
                        <option value="3">Dulce</option>
                        <option value="4">Salado</option>
                    </select required>
                </div>
                <a href="../../index.php">
                    <button type="submit" class="btn btn-primary w-100">Crear Producto</button>
                </a>
            </form>
        </div>
    </div>
    
<?php
require_once "../../../includes/footer.php";
?>