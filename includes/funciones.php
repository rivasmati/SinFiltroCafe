<?php

require_once "database.php";

function listarProductos() {
    try {
        // Conectar a la base de datos
        $conexion = conectarBaseDatos();

        // Consulta SQL para obtener los productos
        $sql = "SELECT id, nombre, descripcion, precio, stock, categoria_id FROM productos";
        $stmt = $conexion->query($sql);

        // Retornar los resultados como array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error al obtener los productos: " . $e->getMessage());
    }
}

function listarClientes() {
    try {
        // Conectar a la base de datos
        $conexion = conectarBaseDatos();

        // Consulta SQL para obtener los productos
        $sql = "SELECT id, nombre, email, telefono, fecha_registro FROM clientes";
        $stmt = $conexion->query($sql);

        // Retornar los resultados como array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error al obtener los productos: " . $e->getMessage());
    }
}



?>