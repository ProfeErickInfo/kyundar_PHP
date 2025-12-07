<?php
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Pragma: no-cache');
ob_end_clean();

// ===== SISTEMA DE SEGURIDAD MEJORADO =====
require_once('security_config.php');

// Verificar autenticación antes de continuar
if (!verificarAutenticacion()) {
    // Redirección segura
    echo "<script>
        if (window.location.hostname === location.hostname) {
            window.location.replace('../sesionOut.html');
        }
    </script>";
    exit;
}

// Obtener datos de sesión de forma segura
$id_usu = (int)($_SESSION['id_usuario'] ?? 0);
$tipoUz = (int)($_SESSION['tipo_U'] ?? 0);
$mifoto = $_SESSION['img_foto'] ?? '';
$minombre2 = $_SESSION['nombre_usu'] ?? '';
$ruta_img = "sub_img/uploads/".$id_usu."/";

// Validación adicional de usuario
if ($id_usu <= 0) {
    logEventoSeguridad('ACCESO_DENEGADO', ['motivo' => 'ID usuario inválido']);
    echo "<script>
        if (window.location.hostname === location.hostname) {
            window.location.replace('../sesionOut.html');
        }
    </script>";
    exit;
}  // Cargar configuración de base de datos
include("../enlace/conexion.php"); 

// Verificar conexión a la base de datos
if (!$conexion) {
    error_log("Error de conexión a la base de datos: " . mysqli_connect_error());
    echo "<div class='alert alert-danger'>Error de conexión. Consulte con su administrador del sistema.</div>";
    exit;
}
/////////////////////////////////////////////////////
//$mifoto=@$_SESSION['img_foto'];
//$minombre2=$_SESSION['nombre_usu'];
///////////////CONSULTA PARA INFORMACION FINANCIERA/////////////////
////////////////////////////del edit////////////////////////////

$nMeses=["Sin Registros","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO", "JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];
/////////////CONSULTAS/////////////////////

$periodo=date("Y");
$NmesA=(int)date("m");
//echo"select SUM(valor) as sumMes from  reg_pago where periodo=".$periodo." and mes=".$NmesA;
$stmt = mysqli_prepare($conexion, "SELECT SUM(valor) as sumMes FROM tbx_reg_pago WHERE periodo=? AND mes=? AND id_club=?");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "iii", $periodo, $NmesA, $id_usu);
    mysqli_stmt_execute($stmt);
    $SumaMes = mysqli_stmt_get_result($stmt);
    $filaSUM = mysqli_fetch_array($SumaMes, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    $SumaMes = (int)($filaSUM['sumMes'] ?? 0);
} else {
    error_log("Error preparando consulta SUM: " . mysqli_error($conexion));
    $SumaMes = 0;
}
$subMes = new NumberFormatter( 'es_CO', NumberFormatter::CURRENCY );
//$buscarPrevio=mysqli_query($conexion,"select * from reg_pago where id_socio=".$idSocio." and mes=".$nMes." and periodo=".$periodo);

$Query = "SELECT f.id_socio, d.nombres, d.apellidos, d.film FROM tbx_reg_pago f INNER JOIN tbx_deportistas d ON f.id_socio = d.id WHERE f.periodo=? AND f.mes=? AND f.id_club=?";
$stmt2 = mysqli_prepare($conexion, $Query);
if ($stmt2) {
    mysqli_stmt_bind_param($stmt2, "iii", $periodo, $NmesA, $id_usu);
    mysqli_stmt_execute($stmt2);
    $listaPagos = mysqli_stmt_get_result($stmt2);
    $ClistP = mysqli_num_rows($listaPagos);
    if($ClistP!=0){
        // Procesar resultados
    }
    mysqli_stmt_close($stmt2);
} else {
    error_log("Error preparando consulta de pagos: " . mysqli_error($conexion));
    $ClistP = 0;
}
$nomMes=$nMeses[$NmesA];

/////////////////////////////////////////////////////////////////////
  
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <link rel="icon" type="image/png" href="../images/ky-icono144x144.png">
<title>KYUNDAR - Panel de Administración</title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<!---------------MEnu-------------------------------->

<script>
    
    function calcular_pago() {
    try {
        var nClase = document.getElementById("txtNclase");
        var vPago = document.getElementById("txtVclase");
        var vSaldo = document.getElementById("txtVpago");
        
        if (nClase && vPago && vSaldo) {
            var nClaseVal = parseFloat(nClase.value) || 0;
            var vPagoVal = parseFloat(vPago.value) || 0;
            vSaldo.value = nClaseVal * vPagoVal;
        }
    } catch (error) {
        console.error('Error en calcular_pago:', error);
    }
}

function calcular_pago_parcial() {
    //alert('es');
    var vPago = document.getElementById("txtVpago");
    var vParcial = document.getElementById("txtParcial");
    var vSaldo = document.getElementById("txtSaldo");
    var vPagoN=parseFloat(vPago.value);
    var vParcialN=parseFloat(vParcial.value);
    var vSaldoN=parseFloat(vSaldo.value);
    if(vParcial==0){
      vParcial.value=vPagoN;
    }else{
      vParcial.value=(vParcialN + vPagoN);
    }
    

    vSaldo.value = vSaldoN-vPagoN;
    
}
</script>
<!---------------Librerias-------------------------------->
<!-- Librerías locales -->
<script src='libros/lib25.js' type='text/javascript'></script>
<script src='libros/libValid25.js' type='text/javascript'></script>
<script src='libros/jquery.watermarkinput.js' type='text/javascript'></script>
<!----Lib Finana----->
<script type="text/javascript" src="libros/libFinan/FunFinan.js"></script>
<!-------->
<script type="text/javascript" src="libros/jfind.js"></script>
<script type="text/javascript" src="libros/jlock.js"></script>

<!-- jQuery moderno (una sola vez) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!----------------------------------------------------------------->
 
<!----------------------fecha------------------------------>
<link rel="stylesheet" type="text/css" href="faces/datedropper.css"> 
<script src="libros/datedropper.js"></script>
<script>
$(document).ready(function(){
    $("#from").dateDropper();
});
</script>


<!-----------------------------------HOJAS DE ESTILO-------------------------------->

<!-- Font Awesome Icons (versión CDN estable con fallback) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Fallback para Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" crossorigin="anonymous">

<!-- Bootstrap 5 (UNA SOLA VERSIÓN) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<!-- jQuery (UNA SOLA VERSIÓN) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
 <!----------------------------------------------------------------->

<script>
function habilita() {
    // Accedemos a los elementos con animación
    const txtAcu = document.getElementById('txtAcudiente');
    const txtDoc = document.getElementById('txtDocumento2');
    const txtTipo = document.getElementById('TipoDocumento2');
    
    if (txtAcu && txtDoc && txtTipo) {
        // Animación de habilitación
        [txtAcu, txtDoc, txtTipo].forEach(element => {
            element.disabled = false;
            element.value = "";
            element.classList.remove('disabled');
            element.classList.add('animate__animated', 'animate__pulse');
        });
        
        txtAcu.focus();
        
        // Quitar animación después de un tiempo
        setTimeout(() => {
            [txtAcu, txtDoc, txtTipo].forEach(element => {
                element.classList.remove('animate__animated', 'animate__pulse');
            });
        }, 1000);
    }
}

function nohabilita() {
    // Accedemos a los elementos con validación mejorada
    const txtAcu = document.getElementById('txtAcudiente');
    const txtDoc = document.getElementById('txtDocumento2');
    const txtTipo = document.getElementById('TipoDocumento2');
    const txtNombres = document.getElementById('txtNombres');
    const txtApellidos = document.getElementById('txtApellidos');
    const tipoDocumento = document.getElementById('TipoDocumento');
    const txtDocumento = document.getElementById('txtDocumento');
    const txtCelular = document.getElementById('txtCelular');
    
    if (txtAcu && txtDoc && txtTipo && txtNombres && txtApellidos) {
        // Deshabilitar con animación
        [txtAcu, txtDoc, txtTipo].forEach(element => {
            element.disabled = true;
            element.classList.add('disabled', 'animate__animated', 'animate__fadeOut');
        });
        
        // Autocompletar datos
        txtAcu.value = (txtNombres.value + ' ' + txtApellidos.value).trim();
        if (tipoDocumento) txtTipo.value = tipoDocumento.value;
        if (txtDocumento) txtDoc.value = txtDocumento.value;
        
        // Enfocar siguiente campo
        if (txtCelular) txtCelular.focus();
        
        // Quitar animación
        setTimeout(() => {
            [txtAcu, txtDoc, txtTipo].forEach(element => {
                element.classList.remove('animate__animated', 'animate__fadeOut');
            });
        }, 500);
    }
}
</script>
<style>
/* ===== DISEÑO PROFESIONAL Y SOBRIO ===== */
:root {
  --primary-color: #1f2937;
  --secondary-color: #374151;
  --accent-color: #3b82f6;
  --light-gray: #f9fafb;
  --medium-gray: #e5e7eb;
  --text-dark: #111827;
  --text-light: #6b7280;
  --white: #ffffff;
  --success: #10b981;
  --warning: #f59e0b;
  --error: #ef4444;
  --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
  --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  --border-radius: 8px;
  --transition: all 0.2s ease;
}

body {
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  background-color: var(--light-gray);
  color: var(--text-dark);
  line-height: 1.5;
  margin: 0;
  padding: 0;
  padding-top: 76px; /* Espacio para el navbar fijo de tb_menu.php */
}

/* Header profesional - DESHABILITADO para usar tb_menu.php */
.professional-header {
  display: none;
  background: var(--white);
  padding: 1rem 0;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
  box-shadow: var(--shadow);
}

.header-content {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.brand {
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--primary-color);
  text-decoration: none;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  font-size: 0.875rem;
  color: var(--text-light);
}

.user-avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: var(--accent-color);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--white);
  font-size: 0.75rem;
  font-weight: 500;
}

/* Contenedor principal */
#DivContenido {
  max-width: 1500px;
  margin: 80px auto 0;
  padding: 2rem 1rem;
  min-height: calc(100vh - 80px);
}

/* Cards profesionales */
.pro-card {
  background: var(--white);
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
  padding: 1.5rem;
  margin-bottom: 1.5rem;
  border: 1px solid var(--medium-gray);
  transition: var(--transition);
}

.pro-card:hover {
  box-shadow: var(--shadow-lg);
  border-color: var(--accent-color);
}

/* Botones profesionales */
.btn-pro {
  background: var(--accent-color);
  color: var(--white);
  border: none;
  padding: 0.5rem 1rem;
  border-radius: var(--border-radius);
  font-weight: 500;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  transition: var(--transition);
  cursor: pointer;
  font-size: 0.875rem;
}

.btn-pro:hover {
  background: #2563eb;
  color: var(--white);
  text-decoration: none;
  transform: translateY(-1px);
}

.btn-pro.secondary {
  background: var(--white);
  color: var(--text-dark);
  border: 1px solid var(--medium-gray);
}

.btn-pro.secondary:hover {
  background: var(--light-gray);
  color: var(--text-dark);
}

/* Tablas profesionales */
.pro-table {
  width: 100%;
  border-collapse: collapse;
  background: var(--white);
  border-radius: var(--border-radius);
  overflow: hidden;
  box-shadow: var(--shadow);
}

.pro-table th {
  background: var(--light-gray);
  color: var(--text-dark);
  font-weight: 600;
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid var(--medium-gray);
  font-size: 0.875rem;
}

.pro-table td {
  padding: 0.75rem;
  border-bottom: 1px solid var(--medium-gray);
  font-size: 0.875rem;
}

.pro-table tr:hover {
  background: var(--light-gray);
}

/* Formularios profesionales */
.form-group {
  margin-bottom: 1rem;
}

.form-label {
  display: block;
  font-weight: 500;
  color: var(--text-dark);
  margin-bottom: 0.25rem;
  font-size: 0.875rem;
}

.form-control {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid var(--medium-gray);
  border-radius: var(--border-radius);
  font-size: 0.875rem;
  transition: var(--transition);
}

.form-control:focus {
  outline: none;
  border-color: var(--accent-color);
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Alertas profesionales */
.alert {
  padding: 0.75rem 1rem;
  border-radius: var(--border-radius);
  margin-bottom: 1rem;
  font-size: 0.875rem;
  border-left: 4px solid;
}

.alert-info {
  background: #eff6ff;
  color: #1e40af;
  border-left-color: var(--accent-color);
}

.alert-success {
  background: #ecfdf5;
  color: #065f46;
  border-left-color: var(--success);
}

.alert-warning {
  background: #fffbeb;
  color: #92400e;
  border-left-color: var(--warning);
}

.alert-danger {
  background: #fef2f2;
  color: #991b1b;
  border-left-color: var(--error);
}

/* Modales profesionales */
.modal-content {
  border: none;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow-lg);
}

.modal-header {
  background: var(--light-gray);
  border-bottom: 1px solid var(--medium-gray);
  border-radius: var(--border-radius) var(--border-radius) 0 0;
  padding: 1rem 1.5rem;
}

.modal-title {
  font-weight: 600;
  color: var(--text-dark);
}

.modal-body {
  padding: 1.5rem;
}

.modal-footer {
  background: var(--light-gray);
  border-top: 1px solid var(--medium-gray);
  border-radius: 0 0 var(--border-radius) var(--border-radius);
  padding: 1rem 1.5rem;
}

/* Estados de carga */
.loading-state {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  color: var(--text-light);
  font-size: 0.875rem;
}

.spinner {
  width: 20px;
  height: 20px;
  border: 2px solid var(--medium-gray);
  border-top-color: var(--accent-color);
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-right: 0.5rem;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
  .header-content {
    padding: 0 1rem;
  }
  
  .brand {
    font-size: 1.25rem;
  }
  
  .user-info {
    font-size: 0.8rem;
  }
  
  #DivContenido {
    padding: 1rem;
  }
  
  .pro-card {
    padding: 1rem;
  }
  
  .pro-table {
    font-size: 0.8rem;
  }
  
  .pro-table th,
  .pro-table td {
    padding: 0.5rem;
  }
}

/* Estados hover sutiles */
.clickable {
  cursor: pointer;
  transition: var(--transition);
}

.clickable:hover {
  background: var(--light-gray);
}

/* Estilos para la imagen del logo */
.logo-image {
    max-width: 100%;
    max-height: 50px;
    width: auto;
    height: auto;
    object-fit: contain;
}

@media (max-width: 768px) {
    .logo-image {
        max-height: 40px;
    }
}

@media (max-width: 480px) {
    .logo-image {
        max-height: 35px;
    }
}

/* ===== FALLBACKS PARA ICONOS ===== */
/* Si Font Awesome no carga, mostrar caracteres Unicode */
.fas::before, .fa::before {
    font-family: "Font Awesome 6 Free", "FontAwesome", sans-serif !important;
    font-weight: 900 !important;
}

/* Fallbacks específicos para iconos principales */
.fa-users::before { content: "👥"; }
.fa-chart-line::before { content: "📈"; }
.fa-dollar-sign::before { content: "$"; }
.fa-calendar::before { content: "📅"; }
.fa-calendar-days::before { content: "📅"; }
.fa-clock::before { content: "⏰"; }
.fa-coins::before { content: "🪙"; }
.fa-chart-pie::before { content: "📊"; }
.fa-user-plus::before { content: "👤+"; }
.fa-user-pen::before { content: "✏️"; }
.fa-user-gear::before { content: "⚙️"; }
.fa-circle-user::before { content: "👤"; }
.fa-hand-holding-dollar::before { content: "💰"; }
.fa-medal::before { content: "🥇"; }
.fa-list-ul::before { content: "📋"; }
.fa-cog::before { content: "⚙️"; }
.fa-box::before { content: "📦"; }
.fa-money-bill-wave::before { content: "💵"; }
.fa-shopping-cart::before { content: "🛒"; }
.fa-search::before { content: "🔍"; }
.fa-camera::before { content: "📷"; }
.fa-id-card::before { content: "🪪"; }
.fa-file-alt::before { content: "📄"; }
.fa-shield-alt::before { content: "🛡️"; }
.fa-building::before { content: "🏢"; }
.fa-sign-out-alt::before { content: "🚪"; }
.fa-minus-circle::before { content: "➖"; }
.fa-circle-check::before { content: "✅"; }
.fa-triangle-exclamation::before { content: "⚠️"; }
.fa-circle-xmark::before { content: "❌"; }
.fa-circle-info::before { content: "ℹ️"; }

/* Asegurar que los iconos se muestren */
i[class*="fa-"] {
    display: inline-block !important;
    font-style: normal !important;
    font-variant: normal !important;
    text-rendering: auto !important;
    line-height: 1 !important;
}

/* Si Font Awesome no está disponible, usar emojis */
@supports not (font-family: "Font Awesome 6 Free") {
    .fas, .fa {
        font-family: "Apple Color Emoji", "Segoe UI Emoji", "Noto Color Emoji", sans-serif !important;
        font-weight: normal !important;
    }
}

/* Clase de fallback para cuando FA no carga completamente */
.fa-fallback .fas::before,
.fa-fallback .fa::before {
    font-family: "Apple Color Emoji", "Segoe UI Emoji", "Noto Color Emoji", sans-serif !important;
    font-weight: normal !important;
}

/* Estilos específicos para iconos problemáticos */
.fas.fa-circle-check:not([data-fa-processed])::before,
.fa-fallback .fas.fa-circle-check::before {
    content: "✅" !important;
}

.fas.fa-minus-circle:not([data-fa-processed])::before,
.fa-fallback .fas.fa-minus-circle::before {
    content: "➖" !important;
}

.fas.fa-triangle-exclamation:not([data-fa-processed])::before,
.fa-fallback .fas.fa-triangle-exclamation::before {
    content: "⚠️" !important;
}

.fas.fa-user-pen:not([data-fa-processed])::before,
.fa-fallback .fas.fa-user-pen::before {
    content: "✏️" !important;
}

.fas.fa-user-gear:not([data-fa-processed])::before,
.fa-fallback .fas.fa-user-gear::before {
    content: "⚙️" !important;
}

.fas.fa-circle-user:not([data-fa-processed])::before,
.fa-fallback .fas.fa-circle-user::before {
    content: "👤" !important;
}

.fas.fa-hand-holding-dollar:not([data-fa-processed])::before,
.fa-fallback .fas.fa-hand-holding-dollar::before {
    content: "💰" !important;
}

.fas.fa-calendar-days:not([data-fa-processed])::before,
.fa-fallback .fas.fa-calendar-days::before {
    content: "📅" !important;
}

.fas.fa-medal:not([data-fa-processed])::before,
.fa-fallback .fas.fa-medal::before {
    content: "🥇" !important;
}

.fas.fa-money-bill-wave:not([data-fa-processed])::before,
.fa-fallback .fas.fa-money-bill-wave::before {
    content: "💵" !important;
}

.fas.fa-shopping-cart:not([data-fa-processed])::before,
.fa-fallback .fas.fa-shopping-cart::before {
    content: "🛒" !important;
}

.fas.fa-id-card:not([data-fa-processed])::before,
.fa-fallback .fas.fa-id-card::before {
    content: "🪪" !important;
}

.fas.fa-file-alt:not([data-fa-processed])::before,
.fa-fallback .fas.fa-file-alt::before {
    content: "📄" !important;
}

.fas.fa-shield-alt:not([data-fa-processed])::before,
.fa-fallback .fas.fa-shield-alt::before {
    content: "🛡️" !important;
}

.fas.fa-sign-out-alt:not([data-fa-processed])::before,
.fa-fallback .fas.fa-sign-out-alt::before {
    content: "🚪" !important;
}
</style>
 <!---------------foto-------------------->
  
<!-- Comentado para evitar conflictos con jQuery moderno -->
<!-- <script type="text/javascript" src="libros/jquery.min.js"></script> -->
<script type="text/javascript" src="libros/jquery.form.js"></script>

<script>
// ===== FUNCIONALIDADES PROFESIONALES =====

// Función para mostrar notificaciones sutiles
function showProNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        z-index: 9999;
        max-width: 400px;
        animation: slideIn 0.3s ease;
    `;
    notification.innerHTML = `
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-${type === 'success' ? 'circle-check' : type === 'warning' ? 'triangle-exclamation' : type === 'danger' ? 'circle-xmark' : 'circle-info'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove después de 4 segundos
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 4000);
}

// Estados de carga mejorados
function showProLoader() {
    const loader = document.createElement('div');
    loader.id = 'proLoader';
    loader.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(249, 250, 251, 0.8);
        backdrop-filter: blur(2px);
        z-index: 9998;
        display: flex;
        align-items: center;
        justify-content: center;
    `;
    loader.innerHTML = `
        <div class="loading-state">
            <div class="spinner"></div>
            <span>Procesando...</span>
        </div>
    `;
    document.body.appendChild(loader);
}

function hideProLoader() {
    const loader = document.getElementById('proLoader');
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => loader.remove(), 200);
    }
}

// Inicialización cuando el documento esté listo
$(document).ready(function() {
    // Verificar si Font Awesome está cargado
    setTimeout(function() {
        const testIcon = document.createElement('i');
        testIcon.className = 'fas fa-home';
        testIcon.style.position = 'absolute';
        testIcon.style.left = '-9999px';
        document.body.appendChild(testIcon);
        
        const computed = window.getComputedStyle(testIcon, ':before');
        const fontFamily = computed.getPropertyValue('font-family');
        
        if (!fontFamily.includes('Font Awesome')) {
            console.warn('⚠️ Font Awesome no se cargó correctamente');
            showProNotification('Los iconos pueden no verse correctamente', 'warning');
            
            // Activar fallbacks CSS
            document.body.classList.add('fa-fallback');
        } else {
            console.log('✅ Font Awesome cargado correctamente');
            
            // Verificar iconos específicos que podrían fallar
            const problematicIcons = [
                { class: 'fas fa-circle-check', name: 'circle-check' },
                { class: 'fas fa-minus-circle', name: 'minus-circle' },
                { class: 'fas fa-triangle-exclamation', name: 'triangle-exclamation' }
            ];
            
            problematicIcons.forEach(icon => {
                const testEl = document.createElement('i');
                testEl.className = icon.class;
                testEl.style.position = 'absolute';
                testEl.style.left = '-9999px';
                document.body.appendChild(testEl);
                
                const computed = window.getComputedStyle(testEl, ':before');
                const content = computed.getPropertyValue('content');
                
                if (!content || content === 'none' || content === '""') {
                    console.warn(`⚠️ Icono ${icon.name} no encontrado, usando fallback`);
                }
                
                document.body.removeChild(testEl);
            });
        }
        
        document.body.removeChild(testIcon);
    }, 2000);
    
    // Mejorar formularios con validación visual
    $('input, select, textarea').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
    
    // Efectos hover sutiles en elementos clickeables
    $('.pro-card, .clickable').hover(
        function() {
            $(this).css('transform', 'translateY(-1px)');
        },
        function() {
            $(this).css('transform', 'translateY(0)');
        }
    );
    
    // Mejorar upload de fotos
    $('#photoimg').on('change', function() {
        showProLoader();
        $("#preview").html(`
            <div class="loading-state">
                <div class="spinner"></div>
                <span>Procesando imagen...</span>
            </div>
        `);
        
        $("#imageform").ajaxForm({
            target: '#preview',
            success: function() {
                hideProLoader();
                showProNotification('Imagen cargada exitosamente', 'success');
            },
            error: function() {
                hideProLoader();
                showProNotification('Error al cargar la imagen', 'danger');
            }
        }).submit();
    });
    
    // Mostrar notificación de bienvenida sutil
    setTimeout(() => {
        showProNotification('Sistema cargado correctamente', 'success');
    }, 1000);
    
    console.log('🎯 Sistema profesional inicializado');
});

// Animaciones CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    
    .focused {
        transform: scale(1.02);
        transition: var(--transition);
    }
`;
document.head.appendChild(style);
</script>

<script type="text/javascript">
// Configuración de carga de imágenes AJAX optimizada
$(document).ready(function() {
    $('#photoimg').on('change', function() {
        $("#preview").html('<img src="../../../sub_img/loader.gif" alt="Cargando..."/>');
        $("#imageform").ajaxForm({
            target: '#preview'
        }).submit();
    });
});
</script>
<script> 
// ===== SISTEMA DE VALIDACIÓN DE SESIÓN MEJORADO =====

// Configuración de seguridad (TEMPORAL - MODO DEBUG)
const SESION_CONFIG = {
    maxInactivity: 60 * 60 * 1000, // 60 minutos (más tiempo)
    checkInterval: 10 * 60 * 1000,  // Verificar cada 10 minutos (menos frecuente)
    warningTime: 15 * 60 * 1000     // Avisar 15 min antes de expirar
};

// Variable para desactivar validación temporal
window.DEBUG_MODE = true;

let ultimaActividad = Date.now();
let timerVerificacion = null;
let timerAdvertencia = null;

// Función principal de validación (MODO DEBUG)
function ejecutaEventoOnclick(idUsu) { 
    try {
        // En modo debug, solo validar ID básico
        if (window.DEBUG_MODE) {
            console.log('🔧 DEBUG MODE: Validación básica para ID:', idUsu);
            if (idUsu <= 0) {
                console.warn('⚠️ ID usuario inválido');
                return false;
            }
            return true;
        }
        
        actualizarActividad(); // Actualizar timestamp de actividad
        
        if (idUsu <= 0) {
            cerrarSesionSegura('Sesión inválida');
            return false;
        }
        
        // Verificar si la sesión ha expirado por inactividad
        if (verificarExpiracionSesion()) {
            cerrarSesionSegura('Sesión expirada por inactividad');
            return false;
        }
        
        return true;
    } catch (error) {
        console.error('Error en ejecutaEventoOnclick:', error);
        // En modo debug, no cerrar sesión por errores
        if (window.DEBUG_MODE) {
            console.warn('🔧 DEBUG: Error ignorado');
            return true;
        }
        cerrarSesionSegura('Error de sistema');
        return false;
    }
}

// Actualizar timestamp de última actividad
function actualizarActividad() {
    ultimaActividad = Date.now();
    
    // Cancelar advertencias previas
    if (timerAdvertencia) {
        clearTimeout(timerAdvertencia);
        timerAdvertencia = null;
    }
    
    // Programar próxima advertencia
    timerAdvertencia = setTimeout(() => {
        mostrarAdvertenciaSesion();
    }, SESION_CONFIG.maxInactivity - SESION_CONFIG.warningTime);
}

// Verificar si la sesión ha expirado
function verificarExpiracionSesion() {
    const tiempoInactivo = Date.now() - ultimaActividad;
    return tiempoInactivo > SESION_CONFIG.maxInactivity;
}

// Mostrar advertencia antes de cerrar sesión
function mostrarAdvertenciaSesion() {
    const tiempoRestante = Math.ceil(SESION_CONFIG.warningTime / 1000 / 60);
    
    if (confirm(`Tu sesión expirará en ${tiempoRestante} minutos por inactividad.\n\n¿Deseas mantener la sesión activa?`)) {
        actualizarActividad(); // Extender sesión
        // Opcional: hacer ping al servidor para refrescar sesión
        ping_servidor();
    } else {
        cerrarSesionSegura('Sesión cerrada por el usuario');
    }
}

// Verificación periódica en segundo plano
function iniciarVerificacionPeriodica() {
    timerVerificacion = setInterval(() => {
        if (verificarExpiracionSesion()) {
            cerrarSesionSegura('Sesión expirada automáticamente');
        }
    }, SESION_CONFIG.checkInterval);
}

// Función centralizada para cerrar sesión
function cerrarSesionSegura(motivo = 'Sesión terminada') {
    console.log('🔒 Cerrando sesión:', motivo);
    
    // Limpiar timers
    if (timerVerificacion) clearInterval(timerVerificacion);
    if (timerAdvertencia) clearTimeout(timerAdvertencia);
    
    // Validar dominio antes de redirigir (seguridad)
    if (window.location.hostname === location.hostname) {
        // Opcional: notificar al servidor del cierre
        notificarCierreSesion();
        
        // Redirigir
        window.location.replace('../sesionOut.html');
    }
}

// Ping opcional al servidor para mantener sesión PHP activa
function ping_servidor() {
    if (window.DEBUG_MODE) {
        console.log('🔧 DEBUG: Ping servidor omitido');
        return;
    }
    
    fetch('ping_session.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({action: 'ping'})
    }).catch(error => {
        console.warn('Ping de sesión falló:', error);
        if (window.DEBUG_MODE) {
            console.log('🔧 DEBUG: Error de ping ignorado');
        }
    });
}

// Notificar cierre al servidor (opcional)
function notificarCierreSesion() {
    if (window.DEBUG_MODE) {
        console.log('🔧 DEBUG: Notificación de cierre omitida');
        return;
    }
    
    navigator.sendBeacon('ping_session.php', 
        JSON.stringify({action: 'logout'})
    );
}

// FUNCIÓN DE EMERGENCIA - Deshabilitar completamente el sistema de seguridad
function deshabilitarSeguridad() {
    window.DEBUG_MODE = true;
    if (timerVerificacion) clearInterval(timerVerificacion);
    if (timerAdvertencia) clearTimeout(timerAdvertencia);
    console.log('🚨 MODO EMERGENCIA: Seguridad completamente deshabilitada');
    console.log('💡 Para rehabilitar: window.DEBUG_MODE = false; location.reload();');
}

// Detectar actividad del usuario en múltiples eventos
function configurarDetectoresActividad() {
    const eventos = ['click', 'keydown', 'mousemove', 'scroll', 'touchstart'];
    
    eventos.forEach(evento => {
        document.addEventListener(evento, () => {
            actualizarActividad();
        }, { passive: true });
    });
    
    // Detectar cambios de ventana/pestaña
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden) {
            // Usuario regresó a la pestaña
            if (verificarExpiracionSesion()) {
                cerrarSesionSegura('Sesión expirada durante ausencia');
            } else {
                actualizarActividad();
            }
        }
    });
    
    // Detectar cierre de ventana
    window.addEventListener('beforeunload', () => {
        notificarCierreSesion();
    });
}

// Inicialización cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    try {
        // Obtener información de sesión desde PHP
        const sessionInfo = <?php echo obtenerInfoSesionJS(); ?>;
        const idUsuario = sessionInfo.usuario_id;
        
        if (idUsuario <= 0) {
            console.warn('⚠️ Usuario ID inválido:', idUsuario);
            if (!window.DEBUG_MODE) {
                cerrarSesionSegura('Usuario no válido');
                return;
            }
        }
        
        console.log('🔐 Sistema de seguridad iniciado - MODO DEBUG:', window.DEBUG_MODE);
        
        if (!window.DEBUG_MODE) {
            actualizarActividad();
            configurarDetectoresActividad();
            iniciarVerificacionPeriodica();
        } else {
            console.log('🔧 DEBUG: Sistemas de seguridad automáticos DESACTIVADOS');
        }
        
        // Mostrar estado de sesión en consola (desarrollo)
        console.log(`👤 Usuario ID: ${idUsuario}`);
        console.log(`⏱️ Timeout inactividad: ${SESION_CONFIG.maxInactivity / 60000} minutos`);
        if (sessionInfo.token_csrf) {
            console.log(`🔑 Token CSRF: ${sessionInfo.token_csrf.substring(0, 8)}...`);
        }
        
    } catch (error) {
        console.error('💥 Error inicializando sistema de seguridad:', error);
        if (!window.DEBUG_MODE) {
            console.warn('🔧 Para debug, establece: window.DEBUG_MODE = true');
        }
    }
});
</script>

  
<!--------------fin foto------------------->

</head>


<body onclick="ejecutaEventoOnclick(<?php echo (int)$id_usu; ?>);" > 

<!-- Header Profesional -->
<div class="professional-header">
  <div class="header-content">
    <div class="brand">
      <i class="fas fa-chart-line" style="color: var(--accent-color); margin-right: 0.5rem;"></i>
      KYUNDAR
    </div>
    <div class="user-info">
      <span>Bienvenido, <strong><?php echo htmlspecialchars($minombre2 ?: 'Usuario'); ?></strong></span>
      <div class="user-avatar">
        <?php if(!empty($mifoto)): ?>
          <img src="<?php echo htmlspecialchars($ruta_img.$mifoto); ?>" alt="Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
        <?php else: ?>
          <i class="fas fa-user"></i>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

 <!--inicio barra de  menu -->
 <?php   

include('tb_menu.php')
  ?>



<!---------------->
 
 

<div id="DivContenido">
  <!-- Dashboard de bienvenida -->
  <div class="pro-card">
    <div style="display: flex; align-items: center; justify-content: between; margin-bottom: 1rem;">
      <div>
        <h2 style="margin: 0; color: var(--text-dark); font-size: 1.5rem; font-weight: 600;">Panel de Control</h2>
        <p style="margin: 0; color: var(--text-light); font-size: 0.875rem;">Bienvenido al sistema de gestión deportiva</p>
      </div>
      <div style="text-align: right; color: var(--text-light); font-size: 0.875rem;">
        <div><i class="fas fa-calendar"></i> <?php echo date('d/m/Y'); ?></div>
        <div><i class="fas fa-clock"></i> <?php echo date('H:i'); ?></div>
      </div>
    </div>
    
    <!-- Estadísticas rápidas -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
      <div style="background: var(--light-gray); padding: 1rem; border-radius: var(--border-radius); border-left: 4px solid var(--success);">
        <div style="display: flex; align-items: center; gap: 0.5rem;">
          <i class="fas fa-dollar-sign" style="color: var(--success);"></i>
          <span style="font-weight: 600; color: var(--text-dark);"><?php echo $subMes->formatCurrency($SumaMes, 'COP'); ?></span>
        </div>
        <div style="font-size: 0.75rem; color: var(--text-light); margin-top: 0.25rem;">Ingresos <?php echo $nomMes; ?></div>
      </div>
      
      <div style="background: var(--light-gray); padding: 1rem; border-radius: var(--border-radius); border-left: 4px solid var(--accent-color);">
        <div style="display: flex; align-items: center; gap: 0.5rem;">
          <i class="fas fa-users" style="color: var(--accent-color);"></i>
          <span style="font-weight: 600; color: var(--text-dark);"><?php echo $ClistP; ?></span>
        </div>
        <div style="font-size: 0.75rem; color: var(--text-light); margin-top: 0.25rem;">Pagos Registrados</div>
      </div>
      
      <div style="background: var(--light-gray); padding: 1rem; border-radius: var(--border-radius); border-left: 4px solid var(--warning);">
        <div style="display: flex; align-items: center; gap: 0.5rem;">
          <i class="fas fa-calendar-days" style="color: var(--warning);"></i>
          <span style="font-weight: 600; color: var(--text-dark);"><?php echo date('Y'); ?></span>
        </div>
        <div style="font-size: 0.75rem; color: var(--text-light); margin-top: 0.25rem;">Año Actual</div>
      </div>
    </div>
  </div>

  <!-- Contenido Principal -->
  <div class="pro-card">
    <!-- Main content -->
    <?php 
    include('tb_desk.php')
    ?>
    <!-- /.content -->
  </div>
</div>


</body>


</html>
<?php
// Cerrar conexión cuando sea necesario
// mysqli_close($conexion);
?>

<!-- Modal Profesional para Documentos -->
<div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel1">
          <i class="fas fa-file-alt" style="color: var(--accent-color); margin-right: 0.5rem;"></i>
          Procesamiento de Documentos
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="modal1dv">
        <div class="loading-state">
          <div class="spinner"></div>
          <span>Cargando contenido...</span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-pro secondary" data-bs-dismiss="modal">
          <i class="fas fa-times"></i>
          Cerrar
        </button>
      </div>
    </div>
  </div>
</div>
 
<!-- Modal Profesional para editar o ver informacion -->
<div class="modal fade" id="modal-f" tabindex="-1" aria-labelledby="modalLabelF" aria-hidden="true">
  <div class="modal-dialog  modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabelF">
          <i class="fas fa-image" style="color: var(--accent-color); margin-right: 0.5rem;"></i>
          Gestión de Información
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="modal-fdv">
        <div class="loading-state">
          <div class="spinner"></div>
          <span>Procesando solicitud...</span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-pro secondary" data-bs-dismiss="modal">
         
          Cerrar
        </button>
      </div>
    </div>
  </div>
</div>
 

<!---------VENTANA MODAL DE EJEMPLO------>
<div class="modal fade" id="modal4" tabindex="-1" aria-labelledby="mLabel4" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mLabel4">Area de Contienda </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal4dv">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
       
      </div>
    </div>
  </div>
 
</div>

<!---------SEGUNDA VENTANA MODAL ------------>
<div class="modal fade" id="modal-Toggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
   <div class="modal-dialog  modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Gestión de Información</h5>
       
      </div>
      <div class="modal-body" id="modal-tg">
        <div class="loading-state">
          <div class="spinner"></div>
          <span>Procesando solicitud...</span>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-bs-target="#modal-f" data-bs-toggle="modal">Regresar</button>
      </div>
    </div>
  </div>
</div>

