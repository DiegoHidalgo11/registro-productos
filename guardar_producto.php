<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Método no permitido.";
    exit;
}

$codigo = trim($_POST["codigo"] ?? "");
$nombre = trim($_POST["nombre"] ?? "");
$bodega = $_POST["bodega"] ?? "";
$sucursal = $_POST["sucursal"] ?? "";
$moneda = $_POST["moneda"] ?? "";
$precio = trim($_POST["precio"] ?? "");
$descripcion = trim($_POST["descripcion"] ?? "");
$materiales = isset($_POST["materiales"]) && is_array($_POST["materiales"])? $_POST["materiales"]: [];

if (
    $codigo === "" || $nombre === "" || $bodega === "" || $sucursal === "" ||
    $moneda === "" || $precio === "" || $descripcion === ""
) {
    echo "Todos los campos obligatorios deben estar completos.";
    exit;
}

if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/', $codigo)) {
    echo "El código del producto debe contener letras y números.";
    exit;
}

if (strlen($codigo) < 5 || strlen($codigo) > 15) {
    echo "El código del producto debe tener entre 5 y 15 caracteres.";
    exit;
}

if (strlen($nombre) < 2 || strlen($nombre) > 50) {
    echo "El nombre del producto debe tener entre 2 y 50 caracteres.";
    exit;
}

if (!preg_match('/^\d+(\.\d{1,2})?$/', $precio)) {
    echo "El precio del producto debe ser un número positivo con hasta dos decimales.";
    exit;
}

if (count($materiales) < 2) {
    echo "Debe seleccionar al menos dos materiales para el producto.";
    exit;
}

if (strlen($descripcion) < 10 || strlen($descripcion) > 1000) {
    echo "La descripción del producto debe tener entre 10 y 1000 caracteres.";
    exit;
}

try {
    $sqlVerificar = "SELECT COUNT(*) FROM productos WHERE codigo = :codigo";
    $stmtVerificar = $conexion->prepare($sqlVerificar);
    $stmtVerificar->bindParam(":codigo", $codigo, PDO::PARAM_STR);
    $stmtVerificar->execute();

    if ($stmtVerificar->fetchColumn() > 0) {
        echo "El código del producto ya está registrado.";
        exit;
    }

    $conexion->beginTransaction();

    $sqlProducto = "INSERT INTO productos
        (codigo, nombre, bodega_id, sucursal_id, moneda_id, precio, descripcion)
        VALUES
        (:codigo, :nombre, :bodega_id, :sucursal_id, :moneda_id, :precio, :descripcion)
        RETURNING id";

    $stmtProducto = $conexion->prepare($sqlProducto);
    $stmtProducto->bindParam(":codigo", $codigo, PDO::PARAM_STR);
    $stmtProducto->bindParam(":nombre", $nombre, PDO::PARAM_STR);
    $stmtProducto->bindParam(":bodega_id", $bodega, PDO::PARAM_INT);
    $stmtProducto->bindParam(":sucursal_id", $sucursal, PDO::PARAM_INT);
    $stmtProducto->bindParam(":moneda_id", $moneda, PDO::PARAM_INT);
    $stmtProducto->bindParam(":precio", $precio);
    $stmtProducto->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
    $stmtProducto->execute();

    $productoId = $stmtProducto->fetchColumn();

    $sqlMaterial = "INSERT INTO producto_material (producto_id, material_id)
                    VALUES (:producto_id, :material_id)";
    $stmtMaterial = $conexion->prepare($sqlMaterial);

    foreach ($materiales as $materialId) {
        $stmtMaterial->bindParam(":producto_id", $productoId, PDO::PARAM_INT);
        $stmtMaterial->bindParam(":material_id", $materialId, PDO::PARAM_INT);
        $stmtMaterial->execute();
    }

    $conexion->commit();

    echo "Producto guardado exitosamente.";
} catch (PDOException $e) {
    if ($conexion->inTransaction()) {
        $conexion->rollBack();
    }
    echo "Error al guardar el producto: " . $e->getMessage();
}
?>