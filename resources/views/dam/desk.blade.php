<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Escritorio - Kyundar</title>
    <link rel="icon" type="image/png" href="/biblio10/images/icons/favicon.ico"/>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .dashboard-container {
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 800px;
            width: 90%;
            text-align: center;
        }
        
        .dashboard-icon {
            font-size: 100px;
            color: #1e3c72;
            margin-bottom: 30px;
        }
        
        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }
        
        .dashboard-subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 30px;
        }
        
        .user-info {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            text-align: left;
        }
        
        .user-info-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 15px;
        }
        
        .user-info-item {
            padding: 15px;
            background: white;
            border-radius: 10px;
            border-left: 4px solid #1e3c72;
        }
        
        .user-info-item strong {
            color: #1e3c72;
            display: block;
            margin-bottom: 5px;
        }
        
        .btn-logout {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: transform 0.3s;
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 87, 108, 0.4);
        }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .feature-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            transition: transform 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-card i {
            font-size: 2rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    
    <div class="dashboard-container">
        <div class="dashboard-icon">
            <i class="fas fa-desktop"></i>
        </div>
        
        <h1 class="dashboard-title">Dashboard Escritorio</h1>
        <p class="dashboard-subtitle">
            Bienvenido a la versión de escritorio de Kyundar
        </p>
        
        <div class="user-info">
            <h3 class="mb-3">Información de la Sesión</h3>
            <div class="user-info-row">
                <div class="user-info-item">
                    <strong><i class="fas fa-building me-2"></i>Club</strong>
                    <span>{{ session('nombre_usu', 'N/A') }}</span>
                </div>
                <div class="user-info-item">
                    <strong><i class="fas fa-user me-2"></i>Usuario ID</strong>
                    <span>#{{ session('idUxer', 'N/A') }}</span>
                </div>
            </div>
            <div class="user-info-row">
                <div class="user-info-item">
                    <strong><i class="fas fa-tag me-2"></i>Tipo Usuario</strong>
                    <span>{{ session('tipo_U', 'N/A') }}</span>
                </div>
                <div class="user-info-item">
                    <strong><i class="fas fa-clock me-2"></i>Sesión Iniciada</strong>
                    <span>{{ date('d/m/Y H:i', session('inicio_sesion', time())) }}</span>
                </div>
            </div>
            <div class="user-info-row">
                <div class="user-info-item">
                    <strong><i class="fas fa-network-wired me-2"></i>IP</strong>
                    <span>{{ session('ip_origen', 'N/A') }}</span>
                </div>
                <div class="user-info-item">
                    <strong><i class="fas fa-shield-alt me-2"></i>Token CSRF</strong>
                    <span>{{ substr(session('token_csrf', 'N/A'), 0, 16) }}...</span>
                </div>
            </div>
        </div>
        
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <strong>Login exitoso!</strong> Estás autenticado en el sistema y puedes acceder a todas las funcionalidades.
        </div>
        
        <div class="feature-grid">
            <div class="feature-card">
                <i class="fas fa-users"></i>
                <div>Gestión de Socios</div>
            </div>
            <div class="feature-card">
                <i class="fas fa-trophy"></i>
                <div>Eventos</div>
            </div>
            <div class="feature-card">
                <i class="fas fa-chart-line"></i>
                <div>Estadísticas</div>
            </div>
            <div class="feature-card">
                <i class="fas fa-cog"></i>
                <div>Configuración</div>
            </div>
        </div>
        
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn btn-logout">
                <i class="fas fa-sign-out-alt me-2"></i>
                Cerrar Sesión
            </button>
        </form>
        
        <div class="mt-4">
            <small class="text-muted">
                Esta es una vista de prueba para el dashboard de escritorio
            </small>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
