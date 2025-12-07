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

$sql = "SELECT * FROM trn25_productos ORDER BY nombre";
$result = mysqli_query($conexion, $sql);

$productos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $productos[] = $row;
}

echo json_encode($productos);
mysqli_close($conexion);
?>
