<?php

// Función para conectar a la base de datos
function conectarBaseDatos() {
    // Parámetros de conexión
    $host = "localhost";
    $usuario = "root";  // Cambia según tu configuración
    $password = "";  // Introduce tu contraseña
    $dbname = "cafeteria";

    try {
        // Crear la conexión usando PDO
        $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        die("Error en la conexión: " . $e->getMessage());
    }
}

?>