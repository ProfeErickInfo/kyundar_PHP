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

$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT v.*, c.nombre as cliente_nombre, c.tipo as cliente_tipo
        FROM trn25_ventas v
        LEFT JOIN trn25_clientes c ON v.id_cliente = c.id_cliente
        ORDER BY v.id_venta DESC
        LIMIT 100";

$result = mysqli_query($conexion, $sql);

$ventas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $ventas[] = $row;
}

echo json_encode($ventas);
mysqli_close($conexion);
?>
