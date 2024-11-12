<?php
require_once "database.php";

function obtenerProductos() {
    try {
        $conexion = conectarBaseDatos();
        $sql = "SELECT id, nombre, descripcion, precio FROM productos";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retornar los productos en formato JSON
        echo json_encode($productos);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al obtener productos: ' . $e->getMessage()]);
    }
}

obtenerProductos();
?>
