<?php
$host = "localhost";
$port = "5432";
$dbname = "registro_productos";
$user = "postgres";
$password = "1234";

try {
    $conexion = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("SET client_encoding TO 'UTF8'");
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>