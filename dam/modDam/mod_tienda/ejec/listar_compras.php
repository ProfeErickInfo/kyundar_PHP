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

$sql = "SELECT c.*, p.nombre as proveedor_nombre
        FROM trn25_compras c
        LEFT JOIN trn25_proveedores p ON c.id_proveedor = p.id_proveedor
        ORDER BY c.id_compra DESC
        LIMIT 100";

$result = mysqli_query($conexion, $sql);

$compras = [];
while ($row = mysqli_fetch_assoc($result)) {
    $compras[] = $row;
}

echo json_encode($compras);
mysqli_close($conexion);
?>
