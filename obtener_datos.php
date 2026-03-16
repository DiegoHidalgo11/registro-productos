<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "conexion.php";

try {
    $stmtBodegas = $conexion->query("SELECT id, nombre FROM bodegas ORDER BY id");
    $bodegas = $stmtBodegas->fetchAll(PDO::FETCH_ASSOC);

    $stmtMonedas = $conexion->query("SELECT id, nombre, simbolo FROM monedas ORDER BY id");
    $monedas = $stmtMonedas->fetchAll(PDO::FETCH_ASSOC);

    $stmtMateriales = $conexion->query("SELECT id, nombre FROM materiales ORDER BY id");
    $materiales = $stmtMateriales->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "bodegas" => $bodegas,
        "monedas" => $monedas,
        "materiales" => $materiales
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "error" => true,
        "mensaje" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}