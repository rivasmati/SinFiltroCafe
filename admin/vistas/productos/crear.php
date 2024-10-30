<?php 
/*
Contenido:

Formulario HTML:
- Un formulario que permita al usuario ingresar datos para un nuevo producto (nombre, precio, disponibilidad en stock).
- Botón para enviar el formulario.
 */

require 'templates/header.php';
require 'includes/data.php'; 

/* Script para procesar el formulario, enviando los datos completados */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_producto = [
        'nombre' => $_POST['nombre'],
        'precio' => $_POST['precio'],
        'en_stock' => isset($_POST['en_stock'])
    ];
    array_push($productos, $nuevo_producto);
    file_put_contents('data.json', json_encode($productos, JSON_PRETTY_PRINT));
    
    // la siguiente función, nos envía de nuevo a index.php una vez cargado el nuevo elemento
    header('Location: index.php');
}
?>

<!-- Formulario HTML -->

<form method="POST" action="crear.php">
    <label for="nombre">Nombre del Producto:</label>
    <input type="text" id="nombre" name="nombre" required>
    
    <label for="precio">Precio:</label>
    <input type="number" step="0.01" id="precio" name="precio" required>
    
    <label for="en_stock">En Stock:</label>
    <input type="checkbox" id="en_stock" name="en_stock">
    
    <button type="submit">Agregar Producto</button>
</form>

<?php
require 'templates/footer.php';
?>