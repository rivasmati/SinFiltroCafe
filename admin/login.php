<?php
require_once "../includes/database.php";
require "../includes/funciones.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    if ($usuario && $contrasena) {
        $usuarioData = verificarUsuario($usuario, $contrasena);
        if ($usuarioData) {
            $_SESSION['usuario'] = $usuarioData['usuario']; // Guarda el usuario en la sesión
            header("Location: ./index.php"); // Redirecciona a index.php en caso de éxito
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos."; // Mensaje de error si las credenciales no coinciden
        }
    } else {
        $error = "Por favor, completa ambos campos.";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sin Filtro Café</title>
    <link rel="icon" href="./img/iconos/sinfiltrocafe_logo.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href='../styles/style.css'>
</head>

<div class="login-container">
    <!-- Imagen de fondo -->
    <div class="login-bg"></div>

    <!-- Formulario de Login -->
    <div class="login-form py-3 px-4">
        <div class="text-center mb-4">
            <img src="../img/iconos/sinfiltrocafe_logo.svg" alt="Logo Cafetería" class="img-fluid" style="width: 100px;">
            <h2>Iniciar Sesión</h2>
        </div>
        
        <!-- Mostrar error si existe -->
        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Formulario -->
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <div class="row">
                <button type="submit" class="col-8 offset-2 btn btn-primary mb-2 rounded">Iniciar Sesión</button>
                <a href="../index.php" class="col-8 offset-2 btn btn-secondary rounded">Volver a la Página Pública</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
