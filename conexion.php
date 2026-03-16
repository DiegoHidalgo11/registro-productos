<?php
// Configuración de conexión a PostgreSQL
$host = "localhost";
$port = "5432";
$dbname = "registro_productos";
$user = "postgres";
$password = "1234";

try {
    // Crear conexión usando PDO
    $conexion = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);

    // Activar manejo de errores mediante excepciones
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Configurar codificación UTF-8
    $conexion->exec("SET client_encoding TO 'UTF8'");

} catch (PDOException $e) {
    // Mostrar error si falla la conexión
    die("Error de conexión: " . $e->getMessage());
}
?>