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
    $id_cliente = $_POST['id_cliente'] ?? null;
    $tipo = $_POST['tipo'] ?? 'externo';
    $referencia_socio = $_POST['referencia_socio'] ?? null;
    $nombre = $_POST['nombre'] ?? '';
    $documento = $_POST['documento'] ?? null;
    $telefono = $_POST['telefono'] ?? null;
    $email = $_POST['email'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $activo = $_POST['activo'] ?? 1;
    
    if (empty($nombre)) {
        echo json_encode(['success' => false, 'message' => 'El nombre es requerido']);
        exit();
    }
    
    if ($id_cliente) {
        // Actualizar
        $sql = "UPDATE trn25_clientes SET tipo=?, referencia_socio=?, nombre=?, documento=?, 
                telefono=?, email=?, direccion=?, activo=? WHERE id_cliente=?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "sissssiii", 
            $tipo, $referencia_socio, $nombre, $documento, 
            $telefono, $email, $direccion, $activo, $id_cliente
        );
    } else {
        // Insertar
        $sql = "INSERT INTO trn25_clientes (tipo, referencia_socio, nombre, documento, telefono, email, direccion, activo) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "sissssi", 
            $tipo, $referencia_socio, $nombre, $documento, 
            $telefono, $email, $direccion, $activo
        );
    }
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Cliente guardado exitosamente']);
    } else {
        throw new Exception(mysqli_error($conexion));
    }
    
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

mysqli_close($conexion);
?>
