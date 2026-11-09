<?php

$servidor = getenv("DB_HOST") ?: "127.0.0.1";
$puerto = getenv("DB_PORT") ?: "3306";
$baseDatos = getenv("DB_NAME") ?: "filosofia_evangelio";
$usuario = getenv("DB_USER") ?: "root";
$contrasena = getenv("DB_PASSWORD") ?: "";

try {

    $conexion = new PDO(
        "mysql:host=$servidor;port=$puerto;dbname=$baseDatos;charset=utf8mb4",
        $usuario,
        $contrasena
    );

    $conexion->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $conexion->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );

} catch (PDOException $error) {

    error_log($error->getMessage());

    die("No fue posible conectar con la base de datos.");

}
?>