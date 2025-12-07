<?PHP
@session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$Xrefer = getenv('HTTP_REFERER');  

// Configuración de errores para producción
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

//if (!$ref || $ref != 'una_url.php')  
if (!$Xrefer) 
{  
    // Mostrar el error y redireccionar
	?>
     <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/salida.html" />
     <?php
}  
else  
{  
    // Se ejecuta el ajax normalmente  
 
?>  
<?php 

	
	include("../../../../enlace/conexion.php");

	if (!$conexion) {
		echo "ERROR: La conexion no se pudo realizar, consulte con su administrador del sistema.";
		echo "<br>Error MySQL: " . mysqli_connect_error();
		exit;
	}

// Conexión establecida

// Verificar que todos los campos requeridos estén presentes
$required_fields = ['txtNombres', 'txtApellidos', 'TipoDocumento', 'txtDocumento', 'txtEmail', 'Sexo', 'txtFechaNac', 'OpSocio', 'LugarNac', 'Barrio', 'txtDireccion', 'Tpsalud', 'txtSalud', 'txtCelular'];
$missing_fields = [];

foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        $missing_fields[] = $field;
    }
}

if (!empty($missing_fields)) {
    echo "ERROR: Faltan campos requeridos: " . implode(', ', $missing_fields);
    exit;
}

// Validación de campos completada

// Obtener y sanitizar datos del formulario
$id_usu_get = isset($_GET['idusu']) ? (int)$_GET['idusu'] : 0;
$id_usu_session = (int)@$_SESSION['id_usuario'];
$id_usu = $id_usu_get > 0 ? $id_usu_get : $id_usu_session;

// Validar que id_usu sea válido
if ($id_usu <= 0) {
    echo "ERROR: ID de usuario inválido";
    exit;
}

// Sanitizar y validar datos del formulario
$txtNombres = mysqli_real_escape_string($conexion, strtoupper(trim($_POST['txtNombres'])));
$txtApellidos = mysqli_real_escape_string($conexion, strtoupper(trim($_POST['txtApellidos'])));
$TipoDocumento = (int)$_POST['TipoDocumento'];
$txtDocumento = mysqli_real_escape_string($conexion, trim($_POST['txtDocumento']));
$txtEmail = trim($_POST['txtEmail']);
$sexo = (int)$_POST['Sexo'];
$txtFechaNac = mysqli_real_escape_string($conexion, trim($_POST['txtFechaNac']));
$OpSocio = (int)$_POST['OpSocio'];
$LugarNac = (int)$_POST['LugarNac'];
$Barrio = mysqli_real_escape_string($conexion, strtoupper(trim($_POST['Barrio'])));
$txtDireccion = mysqli_real_escape_string($conexion, strtoupper(trim($_POST['txtDireccion'])));
$Tpsalud = (int)$_POST['Tpsalud'];
$txtSalud = mysqli_real_escape_string($conexion, strtoupper(trim($_POST['txtSalud'])));
$txtCelular = mysqli_real_escape_string($conexion, trim($_POST['txtCelular']));

// El club debe ser el mismo que el id_usuario (como en SaveSocio.php)
$nomClub = $id_usu;

// Validar email
if (!filter_var($txtEmail, FILTER_VALIDATE_EMAIL)) {
    echo "ERROR: Email inválido: $txtEmail";
    exit;
}

// Validar que no esté vacío el documento
if (empty($txtDocumento)) {
    echo "ERROR: Documento no puede estar vacío";
    exit;
}

// Validar OpSocio (debe ser 1 o 2)
if ($OpSocio < 1 || $OpSocio > 2) {
    echo "ERROR: Tipo de socio inválido: $OpSocio";
    exit;
}

// Valores procesados
$celular = !empty($txtCelular) ? (int)$txtCelular : 1;
$anoHoy = date("Y");

// Verificar si el socio ya existe
$SqlExiste = mysqli_query($conexion, "SELECT documento FROM trn25_socios WHERE documento='$txtDocumento'");

if (!$SqlExiste) {
    echo "ERROR: Error en consulta de verificación: " . mysqli_error($conexion);
    exit;
}

$CantDep = mysqli_num_rows($SqlExiste);

if ($CantDep == 0) {
    // Preparar consulta de inserción con prepared statement
    $sql_insert = "INSERT INTO trn25_socios (nombres, apellidos, tipo_doc, documento, servsalud, email, nombreEps, ano_lectivo, id_usuario, fecha_edit, fecha_nac, lugar_nac, sexo, barrio, direccion, celular, cod_int, id_club, tipo_socio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conexion, $sql_insert);
    
    if (!$stmt) {
        echo "ERROR: Error preparando consulta de inserción: " . mysqli_error($conexion);
        exit;
    }
    
    // Bind parameters
    $bind_result = mysqli_stmt_bind_param($stmt, "ssisissiisiissiiii", 
        $txtNombres,        // nombres (s)
        $txtApellidos,      // apellidos (s) 
        $TipoDocumento,     // tipo_doc (i)
        $txtDocumento,      // documento (s)
        $Tpsalud,           // servsalud (i)
        $txtEmail,          // email (s)
        $txtSalud,          // nombreEps (s)
        $anoHoy,            // ano_lectivo (i)
        $id_usu,            // id_usuario (i)
        $txtFechaNac,       // fecha_nac (s)
        $LugarNac,          // lugar_nac (i)
        $sexo,              // sexo (i)
        $Barrio,            // barrio (s)
        $txtDireccion,      // direccion (s)
        $celular,           // celular (i)
        $txtDocumento,      // cod_int (s)
        $nomClub,           // id_club (i)
        $OpSocio            // tipo_socio (i)
    );
    
    
    if (mysqli_stmt_execute($stmt)) {
        $nuevo_id = mysqli_insert_id($conexion);
        echo "OK|Socio registrado exitosamente. ID: $nuevo_id";
    } else {
        echo "ERROR: Error al insertar socio: " . mysqli_stmt_error($stmt);
    }
    
    mysqli_stmt_close($stmt);

} else {
    echo "ERROR: El socio ya existe con documento: $txtDocumento";
}

// Cerrar conexión
mysqli_close($conexion);

} // Cierre del else principal de verificación de referer

?>