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
    $numero_documento = $_POST['numero_documento'] ?? null;
    $id_proveedor = $_POST['id_proveedor'] ?? null;
    $fecha = $_POST['fecha'] ?? date('Y-m-d');
    $fecha_recepcion = $_POST['fecha_recepcion'] ?? null;
    $estado = $_POST['estado'] ?? 'borrador';
    $notas = $_POST['notas'] ?? '';
    $subtotal = floatval($_POST['subtotal'] ?? 0);
    $impuestos = floatval($_POST['impuestos'] ?? 0);
    $total = floatval($_POST['total'] ?? 0);
    $items = json_decode($_POST['items'] ?? '[]', true);
    
    if (empty($items)) {
        echo json_encode(['success' => false, 'message' => 'Debe agregar al menos un producto']);
        exit();
    }
    
    mysqli_begin_transaction($conexion);
    
    // Insertar compra
    $sql_compra = "INSERT INTO trn25_compras (numero_documento, id_proveedor, fecha, fecha_recepcion, estado, subtotal, impuestos, total, notas, created_by) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conexion, $sql_compra);
    mysqli_stmt_bind_param($stmt, "sisssdddsi", $numero_documento, $id_proveedor, $fecha, $fecha_recepcion, $estado, $subtotal, $impuestos, $total, $notas, $id_usuario);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error al guardar la compra: " . mysqli_error($conexion));
    }
    
    $id_compra = mysqli_insert_id($conexion);
    mysqli_stmt_close($stmt);
    
    // Insertar items
    $sql_item = "INSERT INTO trn25_compras_items (id_compra, id_producto, cantidad, precio_unitario, descuento, impuesto, subtotal) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_item = mysqli_prepare($conexion, $sql_item);
    
    foreach ($items as $item) {
        $id_producto = $item['id_producto'] ?? null;
        $cantidad = floatval($item['cantidad'] ?? 0);
        $precio_unitario = floatval($item['precio_unitario'] ?? 0);
        $descuento = floatval($item['descuento'] ?? 0);
        $tasa_iva = floatval($item['tasa_iva'] ?? 0);
        
        $subtotal_item = ($cantidad * $precio_unitario) - $descuento;
        $impuesto_item = $subtotal_item * ($tasa_iva / 100);
        
        mysqli_stmt_bind_param($stmt_item, "iiddddd", 
            $id_compra, 
            $id_producto, 
            $cantidad, 
            $precio_unitario, 
            $descuento, 
            $impuesto_item, 
            $subtotal_item
        );
        
        if (!mysqli_stmt_execute($stmt_item)) {
            throw new Exception("Error al guardar item: " . mysqli_error($conexion));
        }
    }
    
    mysqli_stmt_close($stmt_item);
    mysqli_commit($conexion);
    
    echo json_encode([
        'success' => true, 
        'message' => 'Compra guardada exitosamente',
        'id_compra' => $id_compra
    ]);
    
} catch (Exception $e) {
    mysqli_rollback($conexion);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

mysqli_close($conexion);
?>
