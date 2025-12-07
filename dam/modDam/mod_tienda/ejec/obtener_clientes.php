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

// Obtener clientes (socios y externos)
$sql = "SELECT c.*, 
        CASE WHEN c.tipo = 'socio' THEN s.nombre ELSE c.nombre END as nombre_completo
        FROM trn25_clientes c
        LEFT JOIN trn25_socios s ON c.referencia_socio = s.id_socio
        WHERE c.activo = 1
        ORDER BY c.tipo DESC, nombre_completo";

$result = mysqli_query($conexion, $sql);

$clientes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $clientes[] = [
        'id_cliente' => $row['id_cliente'],
        'tipo' => $row['tipo'],
        'nombre' => $row['nombre_completo'],
        'documento' => $row['documento'],
        'telefono' => $row['telefono'],
        'email' => $row['email'],
        'direccion' => $row['direccion']
    ];
}

echo json_encode($clientes);
mysqli_close($conexion);
?>
