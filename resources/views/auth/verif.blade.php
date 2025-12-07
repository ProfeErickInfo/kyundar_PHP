<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificando - Kyundar</title>
    <link rel="icon" type="image/png" href="/biblio10/images/icons/favicon.ico"/>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* ===== PALETA ADMINISTRATIVO-DEPORTIVA PREMIUM ===== */
            --primary-color: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary-color: #dc2626;
            --accent-color: #f59e0b;
            --success-color: #059669;
            --gradient-primary: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            --gradient-secondary: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            --gradient-accent: linear-gradient(135deg, #f59e0b 0%, #fbbf24 50%, #fcd34d 100%);
            
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --text-premium: #111827;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --bg-premium: #f1f5f9;
            
            --shadow: 0 10px 25px rgba(30, 64, 175, 0.15);
            --shadow-lg: 0 25px 50px rgba(30, 64, 175, 0.25);
            --shadow-premium: 0 20px 40px rgba(0, 0, 0, 0.1);
            --shadow-glow: 0 0 30px rgba(30, 64, 175, 0.3);
            
            --border-radius: 16px;
            --border-radius-lg: 24px;
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-fast: all 0.2s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gradient-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(245, 158, 11, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(220, 38, 38, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }
        
        body::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 70%;
            height: 70%;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 8s ease-in-out infinite;
        }
        
        .verification-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            padding: 40px 30px;
            box-shadow: var(--shadow-premium);
            text-align: center;
            max-width: 450px;
            width: 90%;
            margin: 20px;
            animation: slideInUp 0.6s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 2;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% { 
                opacity: 0.3;
                transform: scale(1);
            }
            50% { 
                opacity: 0.1;
                transform: scale(1.1);
            }
        }
        
        .logo-container {
            margin-bottom: 30px;
        }
        
        .loading-spinner {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--gradient-primary);
            animation: spin 2s linear infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            position: relative;
            box-shadow: var(--shadow);
        }
        
        .loading-spinner::before {
            content: '';
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .loading-spinner i {
            position: absolute;
            font-size: 28px;
            color: var(--primary-color);
            animation: pulse-icon 1.5s ease-in-out infinite;
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        @keyframes pulse-icon {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.7;
                transform: scale(0.9);
            }
        }
        
        .verification-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--text-premium);
            margin-bottom: 15px;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .verification-subtitle {
            font-size: 1rem;
            color: var(--text-light);
            margin-bottom: 30px;
            line-height: 1.5;
            font-weight: 400;
        }
        
        .progress-container {
            background: var(--bg-premium);
            border-radius: var(--border-radius);
            height: 8px;
            margin: 25px 0;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            background: var(--gradient-primary);
            border-radius: var(--border-radius);
            animation: loading 3s ease-in-out infinite;
            width: 0;
        }
        
        @keyframes loading {
            0% { width: 0; }
            50% { width: 70%; }
            100% { width: 100%; }
        }
        
        .cancel-btn {
            background: var(--gradient-secondary);
            border: none;
            color: white;
            font-weight: 500;
            font-size: 1rem;
            padding: 12px 30px;
            border-radius: 50px;
            transition: var(--transition);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.3);
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        
        .cancel-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(220, 38, 38, 0.4);
            background: linear-gradient(135deg, #b91c1c, #dc2626);
        }
        
        .cancel-btn:active {
            transform: translateY(0);
        }
        
        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(5, 150, 105, 0.1);
            color: var(--success-color);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-top: 20px;
            border: 1px solid rgba(5, 150, 105, 0.3);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .verification-container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .verification-title {
                font-size: 1.5rem;
            }
            
            .verification-subtitle {
                font-size: 0.9rem;
            }
            
            .loading-spinner {
                width: 60px;
                height: 60px;
            }
            
            .loading-spinner::before {
                width: 45px;
                height: 45px;
            }
            
            .loading-spinner i {
                font-size: 20px;
            }
        }
        
        @media (max-width: 480px) {
            .verification-container {
                padding: 25px 15px;
            }
            
            .cancel-btn {
                width: 100%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    
    <div class="verification-container">
        <div class="logo-container">
            <div class="loading-spinner">
                <i class="fas fa-shield-alt"></i>
            </div>
        </div>
        
        <h1 class="verification-title">Verificando Acceso</h1>
        <p class="verification-subtitle">
            Estamos validando tus credenciales de forma segura.<br>
            <small>Si el proceso tarda más de 20 segundos, puedes cancelar y reintentar.</small>
        </p>
        
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>
        
        <div class="security-badge">
            <i class="fas fa-lock"></i>
            <span>Conexión Segura</span>
        </div>
        
        <div class="mt-4">
            <button class="cancel-btn" type="button" onclick="history.back()">
                <i class="fas fa-arrow-left me-2"></i>
                Cancelar
            </button>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-submit form on page load (simulating verif.php behavior)
        // This page is designed to be shown after form submission from login page
        document.addEventListener('DOMContentLoaded', function() {
            // Display the verification screen
            // In actual implementation, this would be triggered by form submission from login page
        });
    </script>
</body>
</html>
