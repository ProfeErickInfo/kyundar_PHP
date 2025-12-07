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

// Consulta preparada para obtener socios
$query = "SELECT a.id, a.nombres, a.apellidos, a.film, a.cod_int, a.documento, a.fecha_nac, a.tipo_socio, a.celular, a.email,
                 (SELECT g.nombre FROM trn25_genero g WHERE g.id = a.sexo) AS genero,
                 (SELECT t.descripcion FROM trn25_tipo_socio t WHERE t.id = a.tipo_socio) AS tSocio
          FROM trn25_socios a 
          WHERE a.id_club = ? 
          ORDER BY a.fecha_edit DESC";

$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "i", $id_usu);
mysqli_stmt_execute($stmt);
$sqlSoc = mysqli_stmt_get_result($stmt);
$CantSoc = mysqli_num_rows($sqlSoc);

// Función para calcular edad correctamente
function calcularEdad($fechaNacimiento) {
    $nacimiento = new DateTime($fechaNacimiento);
    $hoy = new DateTime();
    return $hoy->diff($nacimiento)->y;
}
?>

<style>
.listas-panel {
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px #0001;
  padding: 24px;
  margin-bottom: 32px;
}
.listas-panel h4 {
  margin-bottom: 18px;
}
.export-btns {
  margin-bottom: 16px;
}
.busqueda-socios {
  margin-bottom: 16px;
  max-width: 350px;
}
</style>
<div class="container-fluid">
  <div class="listas-panel">
    <h4>Lista de Socios</h4>
    <div class="export-btns">
      <button class="btn btn-danger btn-sm" id="btnSociosPDF">Exportar PDF</button>
      <button class="btn btn-success btn-sm" id="btnSociosExcel">Exportar Excel</button>
    </div>
    
    <input type="text" class="form-control busqueda-socios" id="buscaSocios" onkeyup="cargarB('modDam/mod_consultas/scrin/lstSocios.php?opbusca=1&oby=&vbusca='+this.value,'dvLista');" placeholder="Buscar socio por nombres o apellidos..." />
             <button style="cursor: pointer;" class="input-group-text" 
                          onclick="cargarB('modDam/mod_consultas/scrin/lstSocios.php?opbusca=1&oby=&vbusca='+document.getElementById('buscaSocios').value+'&idTipo=1&esta=1','dvLista');" 
                          id="btn-buscar">Buscar</button>
    <div id="dvLista">
    <div class="table-responsive">
        
      <table class="table table-bordered table-hover" id="tablaSocios">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Documento</th>
            <th>Nombre completo</th>
            <th>Fecha Nac.</th>
            <th>Celular</th>
            <th>Email</th>
            <th>Tipo de Socio</th>
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se cargan los socios -->
   
           <?php
           $conSoc=0;
            while ($fila = mysqli_fetch_array($sqlSoc, MYSQLI_ASSOC)): 
            $conSoc++;
            ?>
          <tr>
            <td><?php echo htmlspecialchars($conSoc); ?></td>
            <td><?php echo htmlspecialchars($fila['documento']); ?></td>
            <td><?php echo htmlspecialchars($fila['nombres'] . ' ' . $fila['apellidos']); ?></td>
            <td><?php echo htmlspecialchars($fila['fecha_nac']); ?></td>
            <td><?php echo htmlspecialchars($fila['celular'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($fila['email'] ?? ''); ?></td>
             <td>
            <?php
             
              // Por ejemplo, si es titular o beneficiario
             echo  htmlspecialchars($fila['tSocio'] ?? 'N/A'); 
              ?>
            </td>
          </tr>
          <?php endwhile; ?>
          </div>
        </tbody>
      </table>
    </div>
  </div>
  </div>
  <div class="listas-panel">
    <h4>Lista de Beneficiarios</h4>
    <div class="export-btns">
      <button class="btn btn-danger btn-sm" id="btnBenefPDF">Exportar PDF</button>
      <button class="btn btn-success btn-sm" id="btnBenefExcel">Exportar Excel</button>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered table-hover" id="tablaBeneficiarios">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Documento</th>
            <th>Nombre completo</th>
            <th>Parentesco</th>
            <th>Socio titular</th>
            <th>Celular</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se cargan los beneficiarios -->
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Scripts para exportar (solo interfaz, sin backend) -->
<script>
// Aquí iría la lógica JS para exportar, por ahora solo muestra alerta
$('#btnSociosPDF').click(function(){ alert('Exportar Socios a PDF (pendiente)'); });
$('#btnSociosExcel').click(function(){ alert('Exportar Socios a Excel (pendiente)'); });
$('#btnBenefPDF').click(function(){ alert('Exportar Beneficiarios a PDF (pendiente)'); });
$('#btnBenefExcel').click(function(){ alert('Exportar Beneficiarios a Excel (pendiente)'); });
// Búsqueda en la tabla de socios (solo frontend, ejemplo)
$('#buscaSocios').on('keyup', function() {
  var value = $(this).val().toLowerCase();
  $('#tablaSocios tbody tr').filter(function() {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
  });
});
</script>
