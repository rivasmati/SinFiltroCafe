<?php
require_once "includes/database.php";
require_once "includes/header.php";
require "includes/funciones.php";

?>
<section class="pt-4">
    <!-- Cards Section -->
    <div class="container mt-5">
        <h2 class="text-center m-4">Nuestros Productos</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img src="img/productos/cafe-leche.png" class="img-fluid card-img-top" alt="Producto 1">
                    <div class="card-body">
                        <h5 class="card-title">Café</h5>
                        <p class="card-text">Variedad de cafes, no importa el tiempo y el lugar.</p>
                        <a href="productos.php" class="btn btn-dark">Ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="img/productos/jnaranja.png" class="img-fluid card-img-top" alt="Producto 2">
                    <div class="card-body">
                        <h5 class="card-title">Bebidas</h5>
                        <p class="card-text">Suaves y refrescantes bebidas para saciar tu sed.</p>
                        <a href="productos.php" class="btn btn-dark">Ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="img/productos/crossaintc.png" class="img-fluid card-img-top" alt="Producto 3">
                    <div class="card-body">
                        <h5 class="card-title">Dúlce</h5>
                        <p class="card-text">Acompaña tu antojo con algo dúlce.</p>
                        <a href="productos.php" class="btn btn-dark">Ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="img/productos/bagel.png" class="img-fluid card-img-top" alt="Producto 4" style="max-height:400px">
                    <div class="card-body">
                        <h5 class="card-title">Salado</h5>
                        <p class="card-text">Acompaña tu antojo con algo salado.</p>
                        <a href="productos.php" class="btn btn-dark">Ver más</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Coffee Grains Banner Section -->
<section class="coffee-banner">
    <div class="container text-center">
        <h2 class="banner-title mt-4 mb-4">¿Cuál vas a elegir hoy?</h2>
        <div class="banner-content d-flex justify-content-between align-items-center">
            <!-- Left Column: Coffee Grain Descriptions -->
            <div class="grains-left">
                <div class="grain-item">
                    <h5>Grano Árabe</h5>
                    <p>Suave y aromático, ideal para disfrutar en cualquier momento.</p>
                </div>
                <div class="grain-item">
                    <h5>Robusta Intenso</h5>
                    <p>Fuerte y enérgico, perfecto para un impulso extra.</p>
                </div>
                <div class="grain-item">
                    <h5>Grano Descafeinado</h5>
                    <p>Todo el sabor del café sin cafeína, disfrútalo de noche.</p>
                </div>
            </div>
            <!-- Center Image -->
            <div class="banner-image">
                <img src="img/banner/cafebanner.jpg" alt="Variedad de Granos de Café" class="img-fluid w-75">
            </div>
            <!-- Right Column: Coffee Grain Descriptions -->
            <div class="grains-right">
                <div class="grain-item">
                    <h5>Grano Bourbon</h5>
                    <p>Notas dulces y afrutadas, un clásico de gran calidad.</p>
                </div>
                <div class="grain-item">
                    <h5>Geisha Premium</h5>
                    <p>Exquisito y exótico, para los paladares más exigentes.</p>
                </div>
                <div class="grain-item">
                    <h5>Blend Especial</h5>
                    <p>Una mezcla única que resalta lo mejor de cada grano.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<?php require_once "includes/footer.php"; ?>
