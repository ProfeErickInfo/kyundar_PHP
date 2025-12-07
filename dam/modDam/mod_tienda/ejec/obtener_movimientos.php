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

$desde = $_GET['desde'] ?? date('Y-m-01');
$hasta = $_GET['hasta'] ?? date('Y-m-d');
$tipo = $_GET['tipo'] ?? '';

$sql = "SELECT m.*, p.nombre as producto_nombre
        FROM trn25_stock_movimientos m
        INNER JOIN trn25_productos p ON m.id_producto = p.id_producto
        WHERE DATE(m.fecha) BETWEEN ? AND ?";

if ($tipo) {
    $sql .= " AND m.tipo = '" . mysqli_real_escape_string($conexion, $tipo) . "'";
}

$sql .= " ORDER BY m.fecha DESC LIMIT 500";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "ss", $desde, $hasta);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$movimientos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $movimientos[] = $row;
}

echo json_encode($movimientos);
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>
