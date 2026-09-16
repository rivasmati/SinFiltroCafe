<?php

require_once __DIR__ . "/config.php";

// Función para conectar a la base de datos
function conectarBaseDatos() {
    try {
        // Crear la conexión usando PDO, con los datos de config.php
        $conexion = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        die("Error en la conexión: " . $e->getMessage());
    }
}

?>
