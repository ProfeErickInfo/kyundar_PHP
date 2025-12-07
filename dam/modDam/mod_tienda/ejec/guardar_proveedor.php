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

try {
    $id_proveedor = $_POST['id_proveedor'] ?? null;
    $nombre = trim($_POST['nombre'] ?? '');
    $identificacion = trim($_POST['identificacion'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $contacto_nombre = trim($_POST['contacto_nombre'] ?? '');
    
    // Validaciones
    if (empty($nombre)) {
        echo json_encode(['success' => false, 'message' => 'El nombre es requerido']);
        exit();
    }
    
    if (strlen($nombre) < 3 || strlen($nombre) > 255) {
        echo json_encode(['success' => false, 'message' => 'El nombre debe tener entre 3 y 255 caracteres']);
        exit();
    }
    
    if (!empty($identificacion) && !preg_match('/^[0-9\-]+$/', $identificacion)) {
        echo json_encode(['success' => false, 'message' => 'La identificación solo puede contener números y guiones']);
        exit();
    }
    
    if (!empty($telefono) && !preg_match('/^[0-9\+\-\s\(\)]+$/', $telefono)) {
        echo json_encode(['success' => false, 'message' => 'El teléfono tiene caracteres no válidos']);
        exit();
    }
    
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'El email no tiene un formato válido']);
        exit();
    }
    
    // Convertir vacíos a NULL
    $identificacion = empty($identificacion) ? null : $identificacion;
    $telefono = empty($telefono) ? null : $telefono;
    $email = empty($email) ? null : $email;
    $direccion = empty($direccion) ? null : $direccion;
    $contacto_nombre = empty($contacto_nombre) ? null : $contacto_nombre;
    
    if ($id_proveedor) {
        // Actualizar
        $sql = "UPDATE trn25_proveedores SET nombre=?, identificacion=?, telefono=?, email=?, direccion=?, contacto_nombre=? WHERE id_proveedor=?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssi", $nombre, $identificacion, $telefono, $email, $direccion, $contacto_nombre, $id_proveedor);
    } else {
        // Insertar
        $sql = "INSERT INTO trn25_proveedores (nombre, identificacion, telefono, email, direccion, contacto_nombre) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $nombre, $identificacion, $telefono, $email, $direccion, $contacto_nombre);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Proveedor guardado exitosamente']);
    } else {
        throw new Exception(mysqli_error($conexion));
    }
    
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

mysqli_close($conexion);
?>
