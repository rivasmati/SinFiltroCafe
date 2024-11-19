<?php
require_once "includes/database.php";
require_once "includes/header.php";
require "includes/funciones.php";
?>

<main>
    <div class="container mt-5">
      <h1 class="p-3">Nuestros productos</h1>
      <div class="row row-cols-2 row-cols-lg-4 row-cols-md-3 mb-4" id="product-list"></div>
      <form action="./admin/vistas/pedido/crear.php" method="POST"> 
        <div id="smartcart" class="align-items-start w-50"></div>
      </form>
    </div>
</main>

<!-- JQuery -->
<script src="vendors/jquery-3.7.1.min.js"></script>
<!-- SmartCart -->
<script src="vendors/jquery.smartcart/dist/js/jquery.smartCart.min.js"></script>
<script src="./js/productos.js"></script>

<?php require_once "includes/footer.php"; ?>

