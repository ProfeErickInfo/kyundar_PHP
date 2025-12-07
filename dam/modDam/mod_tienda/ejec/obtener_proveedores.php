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

$sql = "SELECT * FROM trn25_proveedores WHERE activo = 1 ORDER BY nombre";
$result = mysqli_query($conexion, $sql);

$proveedores = [];
while ($row = mysqli_fetch_assoc($result)) {
    $proveedores[] = $row;
}

echo json_encode($proveedores);
mysqli_close($conexion);
?>
