<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Móvil - Kyundar</title>
    <link rel="icon" type="image/png" href="/biblio10/images/icons/favicon.ico"/>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .dashboard-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
        
        .dashboard-icon {
            font-size: 80px;
            color: #667eea;
            margin-bottom: 20px;
        }
        
        .dashboard-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        
        .dashboard-subtitle {
            font-size: 1rem;
            color: #666;
            margin-bottom: 20px;
        }
        
        .user-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
        }
        
        .user-info strong {
            color: #667eea;
        }
        
        .btn-logout {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.3s;
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 87, 108, 0.4);
        }
    </style>
</head>
<body>
    
    <div class="dashboard-container">
        <div class="dashboard-icon">
            <i class="fas fa-mobile-alt"></i>
        </div>
        
        <h1 class="dashboard-title">Dashboard Móvil</h1>
        <p class="dashboard-subtitle">
            Bienvenido a la versión móvil de Kyundar
        </p>
        
        <div class="user-info">
            <p><strong>Club:</strong> {{ session('nombre_usu', 'N/A') }}</p>
            <p><strong>Usuario:</strong> #{{ session('idUxer', 'N/A') }}</p>
            <p><strong>Tipo:</strong> {{ session('tipo_U', 'N/A') }}</p>
            <p><strong>Sesión iniciada:</strong> {{ date('d/m/Y H:i', session('inicio_sesion', time())) }}</p>
        </div>
        
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <strong>Login exitoso!</strong> Estás autenticado en el sistema.
        </div>
        
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn btn-logout">
                <i class="fas fa-sign-out-alt me-2"></i>
                Cerrar Sesión
            </button>
        </form>
        
        <div class="mt-3">
            <small class="text-muted">
                Esta es una vista de prueba para el dashboard móvil
            </small>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
