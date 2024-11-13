<?php
require_once "includes/database.php";
require_once "includes/header.php";
require "includes/funciones.php";

?>
     <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/slide1.jpg" class="d-block w-100" alt="Primer slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Bienvenido a Sin Filtro Café</h5>
                    <p>El mejor café artesanal de la ciudad.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/slide2.jpg" class="d-block w-100" alt="Segundo slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Ambiente único</h5>
                    <p>Disfruta de un espacio acogedor y relajante.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/slide3.jpg" class="d-block w-100" alt="Tercer slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Variedad de productos</h5>
                    <p>Desde café filtrado hasta exquisitos postres.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
        </a>
    </div>

    <!-- Cards Section -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Nuestros Productos</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img src="img/productos/espresso.png" class="img-fluid card-img-top" alt="Producto 1">
                    <div class="card-body">
                        <h5 class="card-title">Café</h5>
                        <p class="card-text">Variedad de cafes, no importa el tiempo y el lugar.</p>
                        <a href="productos.html" class="btn btn-dark">Ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="img/productos/jnaranja.png" class="img-fluid card-img-top" alt="Producto 2">
                    <div class="card-body">
                        <h5 class="card-title">Bebidas</h5>
                        <p class="card-text">Suaves y refrescantes bebidas para saciar tu sed.</p>
                        <a href="productos.html" class="btn btn-dark">Ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="img/productos/crossaintc.png" class="img-fluid card-img-top" alt="Producto 3">
                    <div class="card-body">
                        <h5 class="card-title">Dúlce</h5>
                        <p class="card-text">Acompaña tu antojo con algo dúlce.</p>
                        <a href="productos.html" class="btn btn-dark">Ver más</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="img/productos/bagel.png" class="img-fluid card-img-top" alt="Producto 4" style="max-height:400px">
                    <div class="card-body">
                        <h5 class="card-title">Salado</h5>
                        <p class="card-text">Acompaña tu antojo con algo salado.</p>
                        <a href="productos.html" class="btn btn-dark">Ver más</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Us Section -->
    <section id="sobre-nosotros" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center">Sobre Nosotros</h2>
            <p class="text-center mt-3">
Nos apasiona compartir la esencia del café en cada taza. Nuestra historia comenzó en Argentina, cuando Matías Rivas, Francisco Lo Guzzo, Adrián Birnbaun y Aylen Castro decidieron crear un espacio donde el aroma, el sabor y la calidez del café fueran los protagonistas. 


Desde el inicio, nos hemos comprometido a seleccionar granos de alta calidad y a trabajar en conjunto con caficultores locales, asegurándonos de que cada sorbo refleje la dedicación y el esfuerzo que hay detrás de cada proceso. 

En Sin Filtro Café, invitamos a todos a tomarse un momento para disfrutar del presente y descubrir nuevos sabores en un ambiente acogedor y auténtico..</p>
        </div>
    </section>


<? require_once "includes/footer.php"; ?>