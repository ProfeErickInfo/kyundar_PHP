<?php
// ===== CONFIGURACIÓN DE SEGURIDAD KYUNDAR =====
// Archivo: security_config.php
// Propósito: Configuración centralizada de seguridad

/**
 * Configuración de seguridad de sesiones
 */
class SecurityConfig {
    
    // Tiempos de sesión (en segundos)
    const SESSION_TIMEOUT = 1800;      // 30 minutos de inactividad
    const SESSION_MAX_LIFETIME = 7200; // 2 horas máximo absoluto
    const SESSION_WARNING_TIME = 300;  // 5 minutos antes de expirar
    
    // Configuración de cookies de sesión
    const COOKIE_LIFETIME = 0;          // Solo durante la sesión
    const COOKIE_HTTPONLY = true;       // Solo HTTP (no JavaScript)
    const COOKIE_SECURE = false;        // Cambiar a true en HTTPS
    const COOKIE_SAMESITE = 'Strict';   // Protección CSRF
    
    // Límites de seguridad
    const MAX_LOGIN_ATTEMPTS = 5;       // Intentos fallidos máximos
    const LOCKOUT_TIME = 900;          // 15 minutos de bloqueo
    const PASSWORD_MIN_LENGTH = 6;      // Longitud mínima de contraseña
    
    // Headers de seguridad
    const SECURITY_HEADERS = [
        'X-Content-Type-Options' => 'nosniff',
        'X-Frame-Options' => 'DENY',
        'X-XSS-Protection' => '1; mode=block',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' https://ajax.googleapis.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:; connect-src 'self';"
    ];
}

/**
 * Inicializar configuración segura de sesión
 */
function inicializarSesionSegura() {
    // Configurar parámetros de sesión antes de iniciarla
    ini_set('session.cookie_lifetime', SecurityConfig::COOKIE_LIFETIME);
    ini_set('session.cookie_httponly', SecurityConfig::COOKIE_HTTPONLY);
    ini_set('session.cookie_secure', SecurityConfig::COOKIE_SECURE);
    ini_set('session.cookie_samesite', SecurityConfig::COOKIE_SAMESITE);
    ini_set('session.use_strict_mode', 1);
    ini_set('session.use_only_cookies', 1);
    
    // Configurar headers de seguridad
    foreach (SecurityConfig::SECURITY_HEADERS as $header => $value) {
        header("{$header}: {$value}");
    }
    
    // Headers de cache para prevenir almacenamiento
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Iniciar sesión si no está activa
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Validar integridad de sesión
 */
function validarIntegridadSesion() {
    // Verificar timeout por inactividad
    if (isset($_SESSION['ultimo_acceso'])) {
        if ((time() - $_SESSION['ultimo_acceso']) > SecurityConfig::SESSION_TIMEOUT) {
            destruirSesion('Timeout por inactividad');
            return false;
        }
    }
    
    // Verificar tiempo máximo absoluto
    if (isset($_SESSION['inicio_sesion'])) {
        if ((time() - $_SESSION['inicio_sesion']) > SecurityConfig::SESSION_MAX_LIFETIME) {
            destruirSesion('Tiempo máximo de sesión excedido');
            return false;
        }
    }
    
    // Verificar cambio de IP (opcional, puede ser problemático con proxies)
    if (isset($_SESSION['ip_origen'])) {
        $ip_actual = $_SERVER['REMOTE_ADDR'] ?? '';
        if ($_SESSION['ip_origen'] !== $ip_actual) {
            // Solo log, no cerrar sesión automáticamente
            error_log("Advertencia: Cambio de IP detectado - Sesión: {$_SESSION['ip_origen']}, Actual: {$ip_actual}");
        }
    }
    
    return true;
}

/**
 * Actualizar timestamp de actividad
 */
function actualizarActividadSesion() {
    $_SESSION['ultimo_acceso'] = time();
    
    // Establecer datos iniciales si no existen
    if (!isset($_SESSION['inicio_sesion'])) {
        $_SESSION['inicio_sesion'] = time();
        $_SESSION['ip_origen'] = $_SERVER['REMOTE_ADDR'] ?? '';
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
    }
}

/**
 * Destruir sesión de forma segura
 */
function destruirSesion($motivo = 'Cierre manual') {
    // Log del motivo
    $usuario = $_SESSION['nombre_usu'] ?? 'desconocido';
    error_log("Sesión destruida - Usuario: {$usuario}, Motivo: {$motivo}");
    
    // Limpiar todas las variables
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
}

/**
 * Verificar si el usuario está autenticado
 */
function verificarAutenticacion() {
    inicializarSesionSegura();
    
    if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
        return false;
    }
    
    if (!validarIntegridadSesion()) {
        return false;
    }
    
    actualizarActividadSesion();
    return true;
}

/**
 * Middleware de autenticación para páginas protegidas
 */
function requiereAutenticacion($redirigir = '../sesionOut.html') {
    if (!verificarAutenticacion()) {
        // JavaScript para redirección segura
        echo "<script>
            if (window.location.hostname === location.hostname) {
                window.location.replace('{$redirigir}');
            }
        </script>";
        exit;
    }
}

/**
 * Generar token CSRF
 */
function generarTokenCSRF() {
    if (!isset($_SESSION['token_csrf'])) {
        $_SESSION['token_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['token_csrf'];
}

/**
 * Verificar token CSRF
 */
function verificarTokenCSRF($token) {
    return isset($_SESSION['token_csrf']) && hash_equals($_SESSION['token_csrf'], $token);
}

/**
 * Obtener información de sesión para JavaScript
 */
function obtenerInfoSesionJS() {
    $info = [
        'usuario_id' => $_SESSION['id_usuario'] ?? 0,
        'tiempo_restante' => isset($_SESSION['ultimo_acceso']) ? 
            SecurityConfig::SESSION_TIMEOUT - (time() - $_SESSION['ultimo_acceso']) : 0,
        'tiempo_advertencia' => SecurityConfig::SESSION_WARNING_TIME,
        'token_csrf' => generarTokenCSRF()
    ];
    
    return json_encode($info);
}

/**
 * Logs de seguridad mejorados
 */
function logEventoSeguridad($evento, $detalles = []) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
    $usuario = $_SESSION['nombre_usu'] ?? 'anonimo';
    $timestamp = date('Y-m-d H:i:s');
    
    $mensaje = "[{$timestamp}] SEGURIDAD - {$evento} | Usuario: {$usuario} | IP: {$ip}";
    
    if (!empty($detalles)) {
        $mensaje .= " | Detalles: " . json_encode($detalles);
    }
    
    error_log($mensaje);
}
?>