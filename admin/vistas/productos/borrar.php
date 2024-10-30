<?php 
/*
Contenido:

Confirmación de Eliminación (opcional):
Un pequeño formulario o mensaje para confirmar si realmente se desea eliminar el producto.
*/

require 'includes/data.php';

// Eliminar el Producto:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    unset($productos[$id]);
    $productos = array_values($productos); // Reindexar el array
    file_put_contents('data.json', json_encode($productos, JSON_PRETTY_PRINT));
    header('Location: index.php');
}
?>

<!-- Formulario para confirmar la eliminación -->

<form method="POST" action="borrar.php">
    <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
    <p>¿Estás seguro de que deseas eliminar este producto?</p>
    <button type="submit">Sí, eliminar</button>
    <a href="index.php">Cancelar</a>
</form>