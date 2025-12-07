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
$id_compra = $data['id_compra'] ?? 0;

if ($id_compra <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID de compra inválido']);
    exit();
}

try {
    $sql = "UPDATE trn25_compras SET estado = 'anulado' WHERE id_compra = ? AND estado = 'borrador'";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_compra);
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_affected_rows($stmt) === 0) {
        throw new Exception("No se puede anular esta compra");
    }
    
    mysqli_stmt_close($stmt);
    echo json_encode(['success' => true, 'message' => 'Compra anulada exitosamente']);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

mysqli_close($conexion);
?>
