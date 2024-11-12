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

function listarPedidos() {
    try {
        // Conectar a la base de datos
        $conexion = conectarBaseDatos();

        // Consulta SQL para obtener los productos
        $sql = "SELECT pedidos.id, pedidos.cliente_id, pedidos.fecha_pedido, pedidos.medio_pago, pedidos.estado_pedido, clientes.nombre AS cliente_nombre
                FROM pedidos
                JOIN clientes ON pedidos.cliente_id = clientes.id";
        $stmt = $conexion->query($sql);

        // Retornar los resultados como array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error al obtener los productos: " . $e->getMessage());
    }
}

function listarPedidosDetalle($pedido_id) {
    try {
        // Conectar a la base de datos
        $conexion = conectarBaseDatos();

        // Consulta para obtener los detalles del pedido específico
        $sql = "SELECT productos.nombre AS producto_nombre, detalle_pedido.cantidad, productos.precio
                FROM detalle_pedido
                JOIN productos ON detalle_pedido.producto_id = productos.id
                WHERE detalle_pedido.pedido_id = :pedido_id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':pedido_id' => $pedido_id]);

        // Retornar los resultados como array asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Manejo de errores
        die("Error al obtener los detalles del pedido: " . $e->getMessage());
    }
}

// Función para obtener productos con stock disponible
function obtenerProductosConStock() {
    try {
        $conexion = conectarBaseDatos();
        $sql = "SELECT id, nombre FROM productos WHERE stock > 0";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error al obtener productos: " . $e->getMessage());
    }
}

?>