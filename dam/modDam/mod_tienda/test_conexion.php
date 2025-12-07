<?php
session_start();
$_SESSION['id_usuario'] = 1; // Simular sesión para prueba

include("../../../login/enlace/conexion.php");

header('Content-Type: application/json');

if (!$conexion) {
    echo json_encode([
        'error' => true,
        'message' => 'No se pudo conectar a la base de datos',
        'details' => mysqli_connect_error()
    ]);
    exit();
}

echo json_encode([
    'success' => true,
    'message' => 'Conexión exitosa',
    'server_info' => mysqli_get_server_info($conexion)
]);

mysqli_close($conexion);
?>
