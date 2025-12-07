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

$id_usuario = $_SESSION['id_usuario'];

try {
    $id_producto = $_POST['id_producto'] ?? null;
    $tipo = $_POST['tipo'] ?? 'ajuste';
    $cantidad = floatval($_POST['cantidad'] ?? 0);
    $motivo = $_POST['motivo'] ?? '';
    
    if (!$id_producto || $cantidad <= 0) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        exit();
    }
    
    mysqli_begin_transaction($conexion);
    
    // Registrar movimiento
    $sql_mov = "INSERT INTO trn25_stock_movimientos (id_producto, tipo, cantidad, referencia, usuario) 
                VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql_mov);
    mysqli_stmt_bind_param($stmt, "isdss", $id_producto, $tipo, $cantidad, $motivo, $id_usuario);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error al registrar movimiento: " . mysqli_error($conexion));
    }
    
    mysqli_stmt_close($stmt);
    
    // Actualizar inventario
    $multiplicador = ($tipo === 'entrada' || $tipo === 'ajuste') ? 1 : -1;
    $cantidad_ajustada = $cantidad * $multiplicador;
    
    $sql_inv = "INSERT INTO trn25_inventario (id_producto, cantidad) 
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE cantidad = cantidad + ?";
    $stmt_inv = mysqli_prepare($conexion, $sql_inv);
    mysqli_stmt_bind_param($stmt_inv, "idd", $id_producto, $cantidad_ajustada, $cantidad_ajustada);
    
    if (!mysqli_stmt_execute($stmt_inv)) {
        throw new Exception("Error al actualizar inventario: " . mysqli_error($conexion));
    }
    
    mysqli_stmt_close($stmt_inv);
    mysqli_commit($conexion);
    
    echo json_encode(['success' => true, 'message' => 'Ajuste registrado exitosamente']);
    
} catch (Exception $e) {
    mysqli_rollback($conexion);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

mysqli_close($conexion);
?>
