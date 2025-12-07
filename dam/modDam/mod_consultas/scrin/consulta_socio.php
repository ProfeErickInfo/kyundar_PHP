<?php
session_start();
$id_usu = (int)@$_SESSION['id_usuario'];
$Xrefer = getenv('HTTP_REFERER');

// Verificar referer
if (!$Xrefer) {
    echo '<meta http-equiv="Refresh" content="0; URL=' . $_SERVER['SERVER_NAME'] . '/salida.html" />';
    exit;
}

// Conexión a la base de datos
include("../../../../enlace/conexion.php");

if (!$conexion) {
    echo "ERROR: La conexión no se pudo realizar, consulte con su administrador del sistema.";
    exit;
}

// Validar usuario logueado
if ($id_usu <= 0) {
    echo "ERROR: Usuario no válido";
    exit;
}

// Obtener fecha actual para cálculos
$fec_actual = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Socios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container-fluid" style="overflow: visible; min-height: 500px;">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span style="cursor: pointer;" class="input-group-text" 
                          onclick="cargarB('modDam/mod_consultas/ejec/lst-Socios.php?opbusca=1&oby=&vbusca='+document.getElementById('txtBuscar').value+'&idTipo=1&esta=1','dvLista');" 
                          id="btn-buscar">Buscar</span>
                </div>
                <input type="text" 
                       required 
                       class="form-control" 
                       name="txtBuscar" 
                       id="txtBuscar" 
                       placeholder="Buscar socio por nombre, apellido o documento" 
                       onkeyup="cargarB('modDam/mod_consultas/ejec/lst-Socios.php?opbusca=1&oby=&vbusca='+this.value+'&idTipo=1&esta=1','dvLista');">
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>

    <div class="row mb-2">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <h6 class="mb-0">Lista de Socios</h6>
        </nav>
    </div>
<?php
// Consulta preparada para obtener socios
$query = "SELECT a.id, a.nombres, a.apellidos, a.film, a.cod_int, a.documento, a.fecha_nac,
                 (SELECT g.nombre FROM trn25_genero g WHERE g.id = a.sexo) AS genero 
          FROM trn25_socios a 
          WHERE a.id_club = ? 
          ORDER BY a.fecha_edit DESC";

$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "i", $id_usu);
mysqli_stmt_execute($stmt);
$sqlAth = mysqli_stmt_get_result($stmt);
$CantAth = mysqli_num_rows($sqlAth);

// Función para calcular edad correctamente
function calcularEdad($fechaNacimiento) {
    $nacimiento = new DateTime($fechaNacimiento);
    $hoy = new DateTime();
    return $hoy->diff($nacimiento)->y;
}
?>

<!-- VISUALIZACIÓN RESULTADO DE LA CONSULTA -->
<div class="row mb-3" style="color: darkslateblue; font-weight: bold;">
    <div class="col-8 text-left">Total Socios:</div>
    <div class="col-4 text-right"><h6><?php echo $CantAth; ?></h6></div>
</div>
<hr>

<div class="row">
    <div class="col-md-12" id="DivListaAtletas">
        <div id="dvLista" style=" max-height: 600px; text-align: left;">
            <?php if ($CantAth > 0): ?>
                <div class="list-group">

                <?php while ($fila = mysqli_fetch_array($sqlAth, MYSQLI_ASSOC)): 
                    $edad = calcularEdad($fila['fecha_nac']);
                    $anoNacimiento = date("Y", strtotime($fila['fecha_nac']));
                    $genero = $fila['genero'] ?? 'No especificado';
                    
                    // Manejar imagen del socio
                    $rutaImagen = "sub_img/uploads/{$id_usu}/{$fila['film']}";
                    if (!empty($fila['film']) && $fila['film'] !== '0.png' && file_exists($rutaImagen)) {
                        $imagenSocio = $rutaImagen;
                    } else {
                        $imagenSocio = "sub_img/uploads/0.png";
                    }
                    
                    // Enlaces de acción
                    $hrefEditar = "JavaScript:cargarFocus('modDam/mod_registro/scrin/edit_afiliado.php?idDep={$fila['id']}','modal-fdv','carga','txtNombres');";
                    $hrefBeneficiarios = "JavaScript:cargarFocus('modDam/mod_registro/scrin/reg_beneficiario.php?idSocio={$fila['id']}','modal-fdv','carga','');";
                    $hrefImagen = "JavaScript:cargarFocus('sub_img/img_vista.php?idDep={$fila['id']}','{$fila['id']}','carga','');";
                    $hrefFinanciera = "JavaScript:cargarFocus('modDam/mod_registro/scrin/grados.php?idDep={$fila['id']}','modal-fdv','carga','');";
                    $hrefSeguridad = "JavaScript:cargarFocus('modDam/mod_registro/scrin/peso.php?idDep={$fila['id']}','modal-fdv','carga','');";
                ?>
                
                <div class="list-group-item d-flex justify-content-between align-items-start mb-2" id="socio-<?php echo $fila['id']; ?>">
                    <div class="me-3">
                        <img src="<?php echo htmlspecialchars($imagenSocio); ?>" 
                             alt="Foto de <?php echo htmlspecialchars($fila['nombres'] . ' ' . $fila['apellidos']); ?>" 
                             width="50" 
                             height="60" 
                             class="rounded" 
                             style="cursor: pointer; object-fit: cover;" 
                             onclick="<?php echo $hrefImagen; ?>" />
                    </div>
                    
                    <div class="ms-2 me-auto flex-grow-1">
                        <div class="fw-bold mb-1">
                            <?php echo htmlspecialchars($fila['nombres'] . ' ' . $fila['apellidos']); ?>
                        </div>
                        <div class="text-muted small">
                            <span class="me-3"><?php echo htmlspecialchars($genero); ?></span>
                            <span class="me-3">Año: <?php echo $anoNacimiento; ?></span>
                            <span class="me-3">Edad: <?php echo $edad; ?> años</span>
                            <span>Doc: <?php echo htmlspecialchars($fila['documento']); ?></span>
                        </div> 
                    </div>
                    
                    <div class="d-flex flex-wrap gap-1">
                        <span class="badge bg-primary" 
                              style="cursor: pointer;" 
                              onclick="<?php echo $hrefEditar; ?>" 
                              data-bs-toggle="modal" 
                              data-bs-target="#modal-f">Datos Personales</span>
                        
                        <span class="badge bg-warning" 
                              style="cursor: pointer;" 
                              onclick="<?php echo $hrefBeneficiarios; ?>" 
                              data-bs-toggle="modal" 
                              data-bs-target="#modal-f"
                              >Beneficiarios</span>
                        
                        <span class="badge bg-info" 
                              style="cursor: pointer;" 
                              onclick="<?php echo $hrefFinanciera; ?>" 
                              data-bs-toggle="modal" 
                              data-bs-target="#modal-f">Ver Información Financiera</span>
                        
                        <span class="badge bg-secondary" 
                              style="cursor: pointer;" 
                              onclick="<?php echo $hrefSeguridad; ?>" 
                              data-bs-toggle="modal" 
                              data-bs-target="#modal-f">Seguridad</span>
                    </div>
                </div>
                <?php endwhile; ?> 
            </div>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    No hay socios registrados en este club.
                </div>
            <?php endif; ?>
            
            <!-- Resumen final -->
            <div class="row mt-3" style="color: darkslateblue; font-weight: bold;">
                <div class="col-8 text-left">Total Socios:</div>
                <div class="col-4 text-right"><?php echo $CantAth; ?></div>
            </div>
        </div>
    </div>
</div>

<?php
// Limpiar statement
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>

</body>
</html>