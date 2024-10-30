<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sin Filtro Café</title>

    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav class="navbar bg-body-tertiary fixed-top">
            <div class="container-fluid">
                <a class="btn btn-primary d-inline-block d-md-none active" data-bs-toggle="offcanvas" href="#offcanvas" role="button" aria-controls="offcanvas">
                    |||
                </a>
                <a class="navbar-brand" href="./index.php">
                    <img src="./img/iconos/sinfiltrocafe_logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                </a>
                <div class="d-none d-md-inline-block">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link admin" href="./admin/index.php">Active</a>
                        </li>
                    </ul>
                </div>
                <a href="./index.php">
                    <img src="./img/iconos/sinfiltrocafe_logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                </a>
                <!--OffCanvas-->
                <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvas" aria-labelledby="offcanvas">
                    <div class="offcanvas-header d-flex align-items-center">
                        <img src="./img/iconos/sinfiltrocafe_logo.svg" alt="logo sin filtro café" width="30" height="24">
                        <h5 class="offcanvas-title" id="offcanvasDarkLabel">Sin Filtro Café</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#" style="border-radius: 8px;">Active</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
