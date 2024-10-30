<?php 
/* 
Contenido:

Formulario HTML:
- Similar al formulario de creación, pero pre-rellenado con los datos del producto a editar.
- Botón para guardar los cambios.

*/

require 'templates/header.php';
require 'includes/data.php';

// cargar los datos del item a editar, se envían los parámetros vía GET
$id = $_GET['id'];
$producto = $productos[$id];

?>

<!-- Formulario prerellenado -->
<form method="POST" action="editar.php?id=<?php echo $id; ?>">
    <label for="nombre">Nombre del Producto:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
    
    <label for="precio">Precio:</label>
    <input type="number" step="0.01" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>
    
    <label for="en_stock">En Stock:</label>
    <input type="checkbox" id="en_stock" name="en_stock" <?php echo $producto['en_stock'] ? 'checked' : ''; ?>>
    
    <button type="submit">Guardar Cambios</button>
</form>

<?php

/* Script para actualizar el elemento */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productos[$id]['nombre'] = $_POST['nombre'];
    $productos[$id]['precio'] = $_POST['precio'];
    $productos[$id]['en_stock'] = isset($_POST['en_stock']);
    file_put_contents('data.json', json_encode($productos, JSON_PRETTY_PRINT));
    header('Location: index.php');
}

require 'templates/footer.php';

?>