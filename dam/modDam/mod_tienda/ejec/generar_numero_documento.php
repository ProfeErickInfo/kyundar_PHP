<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['numero' => 'V-' . date('Ymd') . '-001']);
    exit();
}

include("../../../../enlace/conexion.php");

if (!$conexion) {
    echo json_encode(['numero' => 'V-' . date('Ymd') . '-001']);
    exit();
}

$tipo = $_GET['tipo'] ?? 'venta';
$prefijo = $tipo === 'venta' ? 'V' : 'C';

// Obtener el último número del día
$fecha_hoy = date('Y-m-d');
$sql = "SELECT numero_documento 
        FROM " . ($tipo === 'venta' ? 'trn25_ventas' : 'trn25_compras') . " 
        WHERE DATE(fecha) = ? 
        AND numero_documento LIKE ?
        ORDER BY id_" . $tipo . " DESC 
        LIMIT 1";

$patron = $prefijo . '-' . date('Ymd') . '-%';
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "ss", $fecha_hoy, $patron);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    // Extraer el número consecutivo
    $partes = explode('-', $row['numero_documento']);
    $consecutivo = intval($partes[2] ?? 0) + 1;
} else {
    $consecutivo = 1;
}

$numero = $prefijo . '-' . date('Ymd') . '-' . str_pad($consecutivo, 3, '0', STR_PAD_LEFT);

echo json_encode(['numero' => $numero]);
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>
