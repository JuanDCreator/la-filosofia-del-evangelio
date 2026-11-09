<?php

require_once "conexion.php";

// Solo aceptar solicitudes POST.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contacto.html");
    exit;
}

// Recibir y limpiar los datos.
$nombre = trim($_POST["nombre"] ?? "");
$numero = trim($_POST["numero"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$tema = trim($_POST["tema"] ?? "");
$peticion = trim($_POST["peticion"] ?? "");
$consentimiento = $_POST["consentimiento"] ?? "";

// Proteger los datos al mostrarlos en HTML.
function seguro($valor) {
    return htmlspecialchars($valor, ENT_QUOTES, "UTF-8");
}

// Lista de errores.
$errores = [];

// Validar nombre.
if ($nombre === "" || strlen($nombre) > 150) {
    $errores[] = "Escribe un nombre válido.";
}

// Validar teléfono.
if ($numero === "" || strlen($numero) > 30) {
    $errores[] = "Escribe un número de teléfono válido.";
}

// Validar correo.
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)
    || strlen($correo) > 150) {
    $errores[] = "Escribe un correo electrónico válido.";
}

// Validar tema.
$temasPermitidos = [
    "biblia",
    "fe-razon",
    "oracion",
    "conversacion",
    "otro"
];

if (!in_array($tema, $temasPermitidos, true)) {
    $errores[] = "Selecciona un tema válido.";
}

// Validar mensaje.
if ($peticion === "") {
    $errores[] = "Escribe tu petición o mensaje.";
}

// Validar consentimiento.
if ($consentimiento !== "acepto") {
    $errores[] = "Debes aceptar la confirmación.";
}

// Nombres de los temas.
$nombreTema = [
    "biblia" => "Preguntas sobre la Biblia",
    "fe-razon" => "Fe, filosofía y razón",
    "oracion" => "Petición de oración",
    "conversacion" => "Hablar con un pastor o líder",
    "otro" => "Otro tema"
];

// Registrar los datos si no existen errores.
$guardado = false;

if (empty($errores)) {

    try {

        $consulta = $conexion->prepare(
            "INSERT INTO contactos
            (nombre, numero, correo, tema, peticion)
            VALUES
            (:nombre, :numero, :correo, :tema, :peticion)"
        );

        $consulta->execute([
            ":nombre" => $nombre,
            ":numero" => $numero,
            ":correo" => $correo,
            ":tema" => $tema,
            ":peticion" => $peticion
        ]);

        $guardado = true;

    } catch (PDOException $error) {

        error_log($error->getMessage());

        $errores[] = "No fue posible registrar tu mensaje. Inténtalo nuevamente.";

    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Resultado del formulario | La filosofía del Evangelio</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header class="site-header">
        <a class="brand" href="index.html">
            La filosofía del Evangelio
        </a>

        <p class="tagline">
            Fe, razón y esperanza en diálogo
        </p>
    </header>

    <nav class="main-nav" aria-label="Navegación principal">
        <ul>
            <li><a href="index.html">Inicio</a></li>
            <li><a href="razones.html">Razones y demostraciones</a></li>
            <li><a href="contacto.html">Una razón para hablar</a></li>
        </ul>
    </nav>

    <main>

        <section class="content-section">

            <div class="contact-form">

                <?php if (!empty($errores)): ?>

                    <h1>Revisa el formulario</h1>

                    <p>
                        No pudimos registrar la información:
                    </p>

                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo seguro($error); ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <a class="button" href="contacto.html">
                        Volver al formulario
                    </a>

                <?php else: ?>

                    <p class="eyebrow">Mensaje registrado</p>

                    <h1>¡Gracias por compartir!</h1>

                    <p>
                        Tu información fue registrada correctamente
                        en nuestra base de datos.
                    </p>

                    <h2>Resumen de tus respuestas</h2>

                    <p>
                        <strong>Nombre:</strong>
                        <?php echo seguro($nombre); ?>
                    </p>

                    <p>
                        <strong>Teléfono:</strong>
                        <?php echo seguro($numero); ?>
                    </p>

                    <p>
                        <strong>Correo:</strong>
                        <?php echo seguro($correo); ?>
                    </p>

                    <p>
                        <strong>Tema:</strong>
                        <?php echo seguro($nombreTema[$tema]); ?>
                    </p>

                    <p><strong>Mensaje:</strong></p>

                    <p>
                        <?php echo nl2br(seguro($peticion)); ?>
                    </p>

                    <div class="notice">
                        Tu registro se encuentra almacenado
                        en la base de datos del proyecto.
                    </div>

                    <a class="button" href="contacto.html">
                        Regresar
                    </a>

                <?php endif; ?>

            </div>

        </section>

    </main>

    <footer class="site-footer">

        <p>
            <strong>La filosofía del Evangelio</strong>
            · Fe, razón y esperanza en diálogo.
        </p>

        <p>
            <a href="index.html">Inicio</a> ·
            <a href="razones.html">Razones y demostraciones</a> ·
            <a href="contacto.html">Contacto</a>
        </p>

    </footer>

</body>
</html>