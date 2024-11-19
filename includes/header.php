<?php
function verificarAdmin($mensajeAdmin, $mensajePublico, $mensajeVistas) {
    $ruta = $_SERVER['SCRIPT_NAME'];

    // Verificar si estamos en una de las carpetas específicas dentro de 'admin/vistas'
    if (
        strpos($ruta, 'vistas/cliente') !== false ||
        strpos($ruta, 'vistas/pedido') !== false ||
        strpos($ruta, 'vistas/producto') !== false
    ) {
        return $mensajeVistas;
    } 
    // Verificar si estamos en el directorio 'admin'
    elseif (strpos($ruta, '/admin') !== false) {
        return $mensajeAdmin;
    } 
    // Ruta pública
    else {
        return $mensajePublico;
    }
}

// Obtener el nombre del archivo actual
$paginaActual = basename($_SERVER['SCRIPT_NAME']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sin Filtro Café</title>
    <link rel="icon" href="./img/iconos/sinfiltrocafe_logo.svg" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" <?php echo verificarAdmin("href='../styles/style.css'","href='./styles/style.css'","href='../../../styles/style.css'"); ?>>
</head>
<body>
    <header>
        <nav class="navbar fixed-top navbar-dark">
            <div class="container-fluid">
                <a class="btn btn-primary d-inline-block d-md-none active" data-bs-toggle="offcanvas" href="#offcanvas" role="button" aria-controls="offcanvas">
                    |||
                </a>
                <a class="navbar-brand justify-content-center align-items-center p-0 m-0" href="./index.php">
                    <img <?php echo verificarAdmin("src='../img/iconos/sinfiltrocafe_logo.svg'","src='./img/iconos/sinfiltrocafe_logo.svg'","src='../../../img/iconos/sinfiltrocafe_logo.svg'"); ?> alt="Logo" width="36" height="36" class="img-fluid">
                </a>
                <div class="d-none d-md-inline-block">
                    <ul class="nav nav-pills">
                    <li class="nav-item">
                            <a class="nav-link <?= $paginaActual == 'index.php' ? 'active' : '' ?>" aria-current="page" href="./index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $paginaActual == 'productos.php' ? 'active' : '' ?>" <?php echo verificarAdmin("href='./productos.php'>Productos","href='./productos.php'>Productos","href='./../../productos.php'>Productos"); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $paginaActual == 'pedidos.php' ||  $paginaActual == 'nosotros.php' ? 'active' : '' ?>" <?php echo verificarAdmin("href='./pedidos.php'>Pedidos","href='./nosotros.php'>Nosotros","href='./../../pedidos.php'>Pedidos"); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $paginaActual == 'clientes.php' ||  $paginaActual == 'contacto.php' ? 'active' : '' ?>" <?php echo verificarAdmin("href='./clientes.php'>Clientes","href='./contacto.php'>Contacto","href='./../../clientes.php'>Clientes"); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link admin ms-3" <?php echo verificarAdmin("href='../index.php'>Público","href='./admin/login.php'>Admin","href='../../../index.php'>Público"); ?></a>
                        </li>
                    </ul>
                </div>
                <a href="./productos.php" class="justify-content-center align-items-center p-0 m-0">
                    <img <?php echo verificarAdmin("src='../img/iconos/sinfiltrocafe_logo.svg'","src='./img/iconos/carrito.svg'","src='../../../img/iconos/sinfiltrocafe_logo.svg'"); ?> alt="Logo" width="32" height="32" class="img-fluid">
                </a>

                <!--OffCanvas-->
                <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvas" aria-labelledby="offcanvas">
                    <div class="offcanvas-header d-flex align-items-center">
                        <img <?php echo verificarAdmin("src='../img/iconos/sinfiltrocafe_logo.svg'","src='./img/iconos/sinfiltrocafe_logo.svg'","src='../../../img/iconos/sinfiltrocafe_logo.svg'"); ?> alt="Logo" width="36" height="36" class="img-fluid">
                        <h5 class="offcanvas-title" id="offcanvasDarkLabel">Sin Filtro Café</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" <?php echo verificarAdmin("href='./productos.php'>Productos","href='#'>Productos","href='./../../productos.php'>Productos"); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" <?php echo verificarAdmin("href='./pedidos.php'>Pedidos","href='#'>Nosotros","href='./../../pedidos.php'>Pedidos"); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" <?php echo verificarAdmin("href='./clientes.php'>Clientes","href='#'>Contacto","href='./../../clientes.php'>Clientes"); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link admin" <?php echo verificarAdmin("href='../index.php'>Público","href='./admin/login.php'>Admin","href='../../../index.php'>Público"); ?></a>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
