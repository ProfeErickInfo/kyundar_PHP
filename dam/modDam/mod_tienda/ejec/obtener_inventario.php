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

$id_producto = $_GET['id_producto'] ?? null;

$sql = "SELECT p.*, 
        COALESCE(SUM(i.cantidad), 0) as cantidad,
        COALESCE(AVG(i.cantidad_minima), 0) as cantidad_minima,
        COALESCE(AVG(i.cantidad_maxima), 0) as cantidad_maxima,
        COALESCE(AVG(i.costo_promedio), p.precio_costo, 0) as costo_promedio,
        COALESCE(SUM(i.cantidad * i.costo_promedio), 0) as valor_total
        FROM trn25_productos p
        LEFT JOIN trn25_inventario i ON p.id_producto = i.id_producto
        WHERE p.activo = 1";

if ($id_producto) {
    $sql .= " AND p.id_producto = " . intval($id_producto);
}

$sql .= " GROUP BY p.id_producto ORDER BY p.nombre";

$result = mysqli_query($conexion, $sql);

$inventario = [];
while ($row = mysqli_fetch_assoc($result)) {
    $inventario[] = $row;
}

echo json_encode($inventario);
mysqli_close($conexion);
?>
