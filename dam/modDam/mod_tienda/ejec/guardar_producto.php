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
    $sku = $_POST['sku'] ?? null;
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? null;
    $unidad_medida = $_POST['unidad_medida'] ?? null;
    $precio_costo = $_POST['precio_costo'] ?? null;
    $precio_venta = $_POST['precio_venta'] ?? null;
    $tasa_iva = $_POST['tasa_iva'] ?? 0;
    $codigo_barra = $_POST['codigo_barra'] ?? null;
    $activo = $_POST['activo'] ?? 1;
    
    if (empty($nombre)) {
        echo json_encode(['success' => false, 'message' => 'El nombre es requerido']);
        exit();
    }
    
    if ($id_producto) {
        // Actualizar
        $sql = "UPDATE trn25_productos SET sku=?, nombre=?, descripcion=?, unidad_medida=?, 
                precio_costo=?, precio_venta=?, tasa_iva=?, codigo_barra=?, activo=?, 
                updated_by=? WHERE id_producto=?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssssdddssii", 
            $sku, $nombre, $descripcion, $unidad_medida, 
            $precio_costo, $precio_venta, $tasa_iva, $codigo_barra, $activo, 
            $id_usuario, $id_producto
        );
    } else {
        // Insertar
        $sql = "INSERT INTO trn25_productos (sku, nombre, descripcion, unidad_medida, 
                precio_costo, precio_venta, tasa_iva, codigo_barra, activo, created_by, updated_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssssdddssii", 
            $sku, $nombre, $descripcion, $unidad_medida, 
            $precio_costo, $precio_venta, $tasa_iva, $codigo_barra, $activo, 
            $id_usuario, $id_usuario
        );
    }
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Producto guardado exitosamente']);
    } else {
        throw new Exception(mysqli_error($conexion));
    }
    
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

mysqli_close($conexion);
?>
