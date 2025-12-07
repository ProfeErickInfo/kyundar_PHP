<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

include("../../../../enlace/conexion.php");

if (!$conexion) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$id_venta = $data['id_venta'] ?? 0;

if ($id_venta <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID de venta inválido']);
    exit();
}

try {
    mysqli_begin_transaction($conexion);
    
    // Actualizar estado a anulado
    $sql = "UPDATE trn25_ventas SET estado = 'anulado' WHERE id_venta = ? AND estado = 'borrador'";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_venta);
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_affected_rows($stmt) === 0) {
        throw new Exception("No se puede anular esta venta");
    }
    
    mysqli_stmt_close($stmt);
    mysqli_commit($conexion);
    
    echo json_encode(['success' => true, 'message' => 'Venta anulada exitosamente']);
    
} catch (Exception $e) {
    mysqli_rollback($conexion);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

mysqli_close($conexion);
?>
