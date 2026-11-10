<?php

$url = getenv("DATABASE_URL");

if (!$url) {
    die("No se encontró la conexión a la base de datos.");
}

$datos = parse_url($url);

$host = $datos["host"];
$puerto = $datos["port"] ?? 5432;
$baseDatos = ltrim($datos["path"], "/");
$usuario = rawurldecode($datos["user"]);
$contrasena = rawurldecode($datos["pass"]);

try {
    $conexion = new PDO(
        "pgsql:host=$host;port=$puerto;dbname=$baseDatos;sslmode=require",
        $usuario,
        $contrasena
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $error) {
    error_log($error->getMessage());
    die("No fue posible conectar con la base de datos.");
}
?>