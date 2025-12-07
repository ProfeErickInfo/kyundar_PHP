<?php
// ===== VALIDADOR DE SESIÓN DEL LADO SERVIDOR =====
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

session_start();

// Configuración de seguridad
define('SESSION_TIMEOUT', 30 * 60); // 30 minutos
define('MAX_LIFETIME', 2 * 60 * 60); // 2 horas máximo absoluto

/**
 * Valida si la sesión actual es válida
 */
function validarSesion() {
    // Verificar si existe sesión
    if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
        return ['valid' => false, 'reason' => 'no_session'];
    }
    
    $id_usuario = (int)$_SESSION['id_usuario'];
    if ($id_usuario <= 0) {
        return ['valid' => false, 'reason' => 'invalid_user'];
    }
    
    // Verificar timeout por inactividad
    if (isset($_SESSION['ultimo_acceso'])) {
        $tiempoInactivo = time() - $_SESSION['ultimo_acceso'];
        if ($tiempoInactivo > SESSION_TIMEOUT) {
            return ['valid' => false, 'reason' => 'timeout_inactivity'];
        }
    }
    
    // Verificar tiempo máximo absoluto
    if (isset($_SESSION['inicio_sesion'])) {
        $tiempoTotal = time() - $_SESSION['inicio_sesion'];
        if ($tiempoTotal > MAX_LIFETIME) {
            return ['valid' => false, 'reason' => 'timeout_absolute'];
        }
    }
    
    // Verificar IP (opcional, puede causar problemas con proxies)
    if (isset($_SESSION['ip_origen'])) {
        $ipActual = $_SERVER['REMOTE_ADDR'] ?? '';
        if ($_SESSION['ip_origen'] !== $ipActual) {
            error_log("Cambio de IP detectado - Sesión: {$_SESSION['ip_origen']}, Actual: {$ipActual}");
            // Descomentar la siguiente línea si quieres validación estricta de IP
            // return ['valid' => false, 'reason' => 'ip_changed'];
        }
    }
    
    // Verificar User Agent (detección básica de hijacking)
    if (isset($_SESSION['user_agent'])) {
        $userAgentActual = $_SERVER['HTTP_USER_AGENT'] ?? '';
        if ($_SESSION['user_agent'] !== $userAgentActual) {
            error_log("Cambio de User-Agent detectado");
            // Descomentar si quieres validación estricta
            // return ['valid' => false, 'reason' => 'agent_changed'];
        }
    }
    
    return ['valid' => true, 'user_id' => $id_usuario];
}

/**
 * Actualiza timestamps de actividad
 */
function actualizarActividad() {
    $_SESSION['ultimo_acceso'] = time();
    
    // Establecer inicio de sesión si no existe
    if (!isset($_SESSION['inicio_sesion'])) {
        $_SESSION['inicio_sesion'] = time();
        $_SESSION['ip_origen'] = $_SERVER['REMOTE_ADDR'] ?? '';
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
    }
}

/**
 * Cierra la sesión de forma segura
 */
function cerrarSesion() {
    // Log del cierre
    $usuario_id = $_SESSION['id_usuario'] ?? 'desconocido';
    error_log("Sesión cerrada - Usuario: {$usuario_id}");
    
    // Limpiar variables de sesión
    $_SESSION = array();
    
    // Destruir cookie de sesión
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destruir sesión
    session_destroy();
    
    return ['success' => true, 'message' => 'Sesión cerrada'];
}

// ===== PROCESAMIENTO DE REQUESTS =====

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? $_GET['action'] ?? '';
    
    switch ($action) {
        case 'ping':
            $validacion = validarSesion();
            
            if ($validacion['valid']) {
                actualizarActividad();
                echo json_encode([
                    'success' => true,
                    'valid' => true,
                    'user_id' => $validacion['user_id'],
                    'timestamp' => time(),
                    'remaining_time' => SESSION_TIMEOUT - (time() - $_SESSION['ultimo_acceso'])
                ]);
            } else {
                cerrarSesion();
                echo json_encode([
                    'success' => false,
                    'valid' => false,
                    'reason' => $validacion['reason'],
                    'message' => 'Sesión inválida o expirada'
                ]);
            }
            break;
            
        case 'check':
            $validacion = validarSesion();
            echo json_encode($validacion);
            break;
            
        case 'logout':
            echo json_encode(cerrarSesion());
            break;
            
        case 'extend':
            $validacion = validarSesion();
            
            if ($validacion['valid']) {
                actualizarActividad();
                echo json_encode([
                    'success' => true,
                    'message' => 'Sesión extendida',
                    'new_expiry' => time() + SESSION_TIMEOUT
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se puede extender sesión inválida'
                ]);
            }
            break;
            
        default:
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Acción no válida',
                'valid_actions' => ['ping', 'check', 'logout', 'extend']
            ]);
    }
    
} catch (Exception $e) {
    error_log("Error en ping_session.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error interno del servidor'
    ]);
}
?>