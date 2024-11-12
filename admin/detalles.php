<?php
require_once "../includes/header.php";
require_once "../includes/database.php";
require "../includes/funciones.php";

if (isset($_GET['id'])) {
    $pedido_id = $_GET['id'];
    $detalles = listarPedidosDetalle($pedido_id);
} else {
    die("ID de pedido no especificado.");
}
?>


<div class="container mt-5">
    <h1 class="text-center my-4">Detalles del Pedido #<?= htmlspecialchars($pedido_id) ?></h1>
    <?= include "../includes/atras.php"; ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $index = 1;
                foreach ($detalles as $detalle): 
                    $total = $detalle['cantidad'] * $detalle['precio'];
                ?>
                    <tr>
                        <td><?= $index++ ?></td>
                        <td><?= htmlspecialchars($detalle['producto_nombre']) ?></td>
                        <td><?= htmlspecialchars($detalle['cantidad']) ?></td>
                        <td>$<?= htmlspecialchars($detalle['precio']) ?></td>
                        <td>$<?= number_format($total, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<? require_once "../includes/footer.php"; ?>
