<?php
require_once "../../../includes/database.php";
require_once "../../../includes/header.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria_id = $_POST['categoria_id'];

    // Verificar si el archivo fue subido correctamente y existe en $_FILES
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen'];
        
        // Ruta de la carpeta donde guardar las imágenes
        $carpetaDestino = '../../../img/productos/';
        
        // Verificar si la carpeta de destino existe; si no, crearla
        if (!is_dir($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        // Procesar y mover la imagen
        $nombreImagen = basename($imagen['name']);
        $rutaImagen = $carpetaDestino . $nombreImagen;

        if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
            try {
                $conexion = conectarBaseDatos();
                $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) 
                        VALUES (:nombre, :descripcion, :precio, :stock, :categoria_id, :imagen)";
                $stmt = $conexion->prepare($sql);
                $stmt->execute([
                    ':nombre' => $nombre,
                    ':descripcion' => $descripcion,
                    ':precio' => $precio,
                    ':stock' => $stock,
                    ':categoria_id' => $categoria_id,
                    ':imagen' => $nombreImagen  // Usamos el nombre de la imagen en lugar del array completo
                ]);
                echo '<div class="alert alert-success">Producto creado exitosamente.</div>';
                echo '<script>setTimeout(() => { window.location.href = "../../productos.php"; }, 1500);</script>';
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger">Error al crear el producto: ' . $e->getMessage() . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Error al mover la imagen al directorio de destino.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Error al subir la imagen. Asegúrate de que el archivo es válido.</div>';
    }
}
?>


    <div class="container mt-5">
    <h1 class="text-center mb-4">Crear producto</h1>
    <?= include "../../../includes/atras.php"; ?>
        <div class="row">
            <form method="POST" action="crear.php" enctype="multipart/form-data" class="shadow p-4 rounded bg-dark col-12 col-md-8 col-lg-6 offset-md-2 offset-lg-3">
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
                <div class="mb-3">
                    <label for="imagen" class="form-label text-light">Imagen del Producto</label>
                    <input type="file" name="imagen" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Crear Producto</button>
            </form>
        </div>
    </div>
    
<?php
require_once "../../../includes/footer.php";
?>