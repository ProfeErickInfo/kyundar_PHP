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
    // Recibir datos del formulario
    $numero_documento = $_POST['numero_documento'] ?? null;
    $id_cliente = $_POST['id_cliente'] ?? null;
    $fecha = $_POST['fecha'] ?? date('Y-m-d');
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
    
    // Comenzar transacción
    mysqli_begin_transaction($conexion);
    
    // Insertar venta
    $sql_venta = "INSERT INTO trn25_ventas (numero_documento, id_cliente, fecha, estado, subtotal, impuestos, total, notas, created_by) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conexion, $sql_venta);
    mysqli_stmt_bind_param($stmt, "sissdddsi", $numero_documento, $id_cliente, $fecha, $estado, $subtotal, $impuestos, $total, $notas, $id_usuario);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error al guardar la venta: " . mysqli_error($conexion));
    }
    
    $id_venta = mysqli_insert_id($conexion);
    mysqli_stmt_close($stmt);
    
    // Insertar items de la venta
    $sql_item = "INSERT INTO trn25_ventas_items (id_venta, id_producto, cantidad, precio_unitario, descuento, impuesto, subtotal) 
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
            $id_venta, 
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
    
    // Si el estado es confirmado, actualizar inventario
    if ($estado === 'confirmado') {
        // Los triggers de la base de datos se encargarán de actualizar el inventario
    }
    
    // Confirmar transacción
    mysqli_commit($conexion);
    
    echo json_encode([
        'success' => true, 
        'message' => 'Venta guardada exitosamente',
        'id_venta' => $id_venta
    ]);
    
} catch (Exception $e) {
    // Revertir transacción en caso de error
    mysqli_rollback($conexion);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

mysqli_close($conexion);
?>
