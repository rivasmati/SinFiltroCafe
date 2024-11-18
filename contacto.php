<?php
require_once "includes/database.php";
require_once "includes/header.php";
require "includes/funciones.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $email = htmlspecialchars($_POST["email"]);
    $mensaje = htmlspecialchars($_POST["mensaje"]);

    if (!empty($nombre) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($mensaje)) {
        $para = "info@sinfiltrocafe.com";
        $asunto = "Mensaje de contacto";
        $contenido = "Nombre: $nombre\nEmail: $email\nMensaje:\n$mensaje";

        if (mail($para, $asunto, $contenido)) {
            $alerta = "¡Tu mensaje fue enviado con éxito! Te responderemos pronto.";
            $alerta_tipo = "success";
        } else {
            $alerta = "Hubo un error al enviar tu mensaje. Por favor, intentá de nuevo.";
            $alerta_tipo = "danger";
        }
    } else {
        $alerta = "Por favor, completá todos los campos correctamente.";
        $alerta_tipo = "warning";
    }
}
?>

<div class="container py-5">
    <h1 class="text-center m-4">Contactanos</h1>
    
    <?php if (isset($alerta)): ?>
        <div class="alert alert-<?= $alerta_tipo ?>" role="alert">
            <?= $alerta ?>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="p-4 shadow rounded bg-warning">
                <h3 class="text-center">Horarios y ubicación</h3>
                <ul class="list-group list-group-flush mt-3">
                    <li class="list-group-item bg-warning"><strong>Lunes a Viernes:</strong> 8:00 AM - 8:00 PM</li>
                    <li class="list-group-item bg-warning"><strong>Sábados:</strong> 9:00 AM - 8:00 PM</li>
                    <li class="list-group-item bg-warning"><strong>Domingos:</strong> 9:00 AM - 8:00 PM</li>
                </ul>
                <div class="mt-3">
                    <h5 class="text-center"><i class="bi bi-geo-alt-fill"></i> Nos encontramos en:</h5>
                    <p class="text-center mb-0">Av. del Libertador 6796, Buenos Aires. </p>
                </div>
            </div>
        </div>
    
        <form action="contacto.php" method="POST" class="m-auto p-4 shadow rounded bg-light col-md-6">
            <h3 class="text-center">Enviá tu consulta</h3>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-warning w-100">Enviar</button>
        </form>
    </div>
</div>


<?php require_once "includes/footer.php"; ?>