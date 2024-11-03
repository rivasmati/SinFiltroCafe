<?php
require_once "../../../includes/database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    try {
        $conexion = conectarBaseDatos();
        $sql = "DELETE FROM clientes WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        echo '<div class="alert alert-success">Producto con ID ' . $id . ' borrado exitosamente.</div>';
        header("refresh:0.5;url=../../clientes.php");
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error al borrar el producto: ' . $e->getMessage() . '</div>';
    }
}
?>


