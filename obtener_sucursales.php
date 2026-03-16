<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "conexion.php";

if (!isset($_GET["bodega_id"]) || empty($_GET["bodega_id"])) {
    echo json_encode([]);
    exit;
}

$bodegaId = $_GET["bodega_id"];

try {
    $sql = "SELECT id, nombre FROM sucursales WHERE bodega_id = :bodega_id ORDER BY id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":bodega_id", $bodegaId, PDO::PARAM_INT);
    $stmt->execute();

    $sucursales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($sucursales, JSON_UNESCAPED_UNICODE);
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "error" => true,
        "mensaje" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
?>