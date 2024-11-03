<?php
require_once "../../../includes/database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    try {
        $conexion = conectarBaseDatos();
        $sql = "DELETE FROM pedidos WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        echo '<div class="alert alert-success">Pedido con ID ' . $id . ' borrado exitosamente.</div>';
        header("refresh:0.5;url=../../pedidos.php");
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error al borrar el pedido: ' . $e->getMessage() . '</div>';
    }
}
?>


