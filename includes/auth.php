<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Corta la ejecucion y redirige al login si no hay una sesion de administrador activa.
// Las vistas dentro de admin/vistas estan un nivel mas profundo, por eso el chequeo de ruta.
function verificarSesionAdmin() {
    if (empty($_SESSION['usuario'])) {
        $rutaLogin = (strpos($_SERVER['SCRIPT_NAME'], '/vistas/') !== false) ? '../../login.php' : 'login.php';
        header("Location: $rutaLogin");
        exit;
    }
}
