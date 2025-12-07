<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([]);
    exit();
}

include("../../../../enlace/conexion.php");

if (!$conexion) {
    echo json_encode([]);
    exit();
}

$termino = $_GET['q'] ?? '';

if (strlen($termino) < 2) {
    echo json_encode([]);
    exit();
}

// Buscar productos con stock disponible
$sql = "SELECT p.*, 
        COALESCE(SUM(i.cantidad), 0) as stock
        FROM trn25_productos p
        LEFT JOIN trn25_inventario i ON p.id_producto = i.id_producto
        WHERE p.activo = 1 
        AND (p.nombre LIKE ? OR p.sku LIKE ? OR p.codigo_barra LIKE ?)
        GROUP BY p.id_producto
        ORDER BY p.nombre
        LIMIT 10";

$busqueda = "%{$termino}%";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "sss", $busqueda, $busqueda, $busqueda);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$productos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $productos[] = [
        'id_producto' => $row['id_producto'],
        'sku' => $row['sku'],
        'nombre' => $row['nombre'],
        'precio_venta' => $row['precio_venta'],
        'tasa_iva' => $row['tasa_iva'],
        'stock' => $row['stock']
    ];
}

echo json_encode($productos);
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>
