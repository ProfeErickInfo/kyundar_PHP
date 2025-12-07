<?php
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$idSocio=(int)@$_GET['idSocio'];
$Xrefer = getenv('HTTP_REFERER');




if (!$Xrefer) 
{  
    // Mostrar el error y redireccionar
	?>
     <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/salida.html" />
     <?php
     exit();
} 

include("../../../../enlace/conexion.php");

	if (!$conexion) {		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";
		exit();

	}
//-------------------------------consultar al socio titular-----------------------------
$sqlSocios = mysqli_query($conexion,"select d.id, d.docRes, d.tipoDoc,  d.celular, d.email, d.nombres, d.apellidos,  d.tipo_socio    from trn25_socios d where d.id=".$idSocio);
$resultados=mysqli_fetch_array($sqlSocios, MYSQLI_ASSOC);
@$CantC =(int)mysqli_num_rows($sqlSocios);
if($CantC==0){
    echo "ERROR: El socio titular no existe, consulte con el administrador del sistema.";
    exit();
}
$nSocioTitular = $resultados['nombres']." ".$resultados['apellidos'];
$idSocio = $resultados['id'];
$hrefEditBene = "JavaScript:cargarFocus('modDam/mod_registro/scrin/edit_beneficiario.php?idSocio={$fila['id']}','modal-tg','carga','');";
                   
//-------------------------------fin consultar al socio titular-----------------------------
?>
<!-- Solo la interfaz visual, sin lógica de guardado -->
<style>
.registro-form {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 !important;
    padding: 20px !important;
}
.registro-form .row { margin-bottom: 15px; }
.registro-form .form-control,
.registro-form .form-select {
    border: 1px solid #d1d5db;
    border-radius: 6px;
    padding: 8px 12px;
    margin-bottom: 10px;
}
.registro-form .form-control:focus,
.registro-form .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.registro-form label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 5px;
    display: block;
}
.registro-form h5 {
    color: #1f2937;
    font-weight: 600;
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 10px;
}
</style>
<script src="../../libros/lib25.js"></script>
<script src="../../libros/libValid25.js"></script>
<div class="container-fluid registro-form">
<div id="carga" style="display: none; text-align: center; padding: 20px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px;">
    <i class="fas fa-spinner fa-spin"></i> Procesando registro, por favor espere...
</div>
<h5 style="margin-bottom: 20px;">Registro de Beneficiario</h5>
<form id="formBenef" name="formBenef" method="post" action="#">
<input type="hidden" name="idSocio" value="<?= $idSocio ?>">
<div class="row">
 <div class="col-md-6"><label>Socio titular</label>
      <input type="text" class="form-control" value=" <?= $nSocioTitular ?>" disabled />
 </div>
 <div class="col-md-2"><label>Tipo Doc.</label>
      <select class="form-select" name="TipoDocumento" id="TipoDocumento" required>
        <option value="1">CC</option>
        <option value="2">TI</option>
        <option value="3">CE</option>
      </select>
 </div>
 <div class="col-md-2"><label>Número</label>
      <input type="number" name="txtDocumento" placeholder="Documento" id="txtDocumento" class="form-control" required />
 </div>
 <div class="col-md-2"><label>Género</label>
      <select name="Sexo" id="Sexo" class="form-control" required>
        <option value="1">Masculino</option>
        <option value="2">Femenino</option>
      </select>
 </div>
</div>
<div class="row">
 <div class="col-md-3"><label>Nombre(s)</label>
      <input type="text" name="txtNombres" id="txtNombres" placeholder="Nombres" class="form-control" onkeydown="return sololetras(event,'txtNombres')"/>
 </div>
 <div class="col-md-3"><label>Apellido(s)</label>
      <input type="text" name="txtApellidos" placeholder="Apellidos" id="txtApellidos" class="form-control" onkeydown="return sololetras(event,'txtApellidos')"/>
 </div>
 <div class="col-md-3"><label>Fecha de Nacimiento</label>
      <input type="date" name="txtFechaNac" class="form-control" id="txtFechaNac" required />
 </div>
 <div class="col-md-3"><label>Lugar de Nacimiento</label>
      <input type="text" name="LugarNac" id="LugarNac" class="form-control"/>
 </div>
</div>
<div class="row">
 <div class="col-md-3"><label>Barrio</label>
      <input type="text" name="Barrio" id="Barrio" class="form-control"/>
 </div>
 <div class="col-md-3"><label>Dirección</label>
      <input type="text" name="txtDireccion" placeholder="Dirección" id="txtDireccion" class="form-control"/>
 </div>
 <div class="col-md-3"><label>Tipo. Serv</label>
      <select name="Tpsalud" id="Tpsalud" class="form-control">
        <option value="1">Contributivo</option>
        <option value="2">Subsidiado</option>
      </select>
 </div>
 <div class="col-md-3"><label>Serv. de salud</label>
      <input type="text" name="txtSalud" placeholder="EPS" id="txtSalud" class="form-control"/>
 </div>
</div>
<div class="row">
 <div class="col-md-3"><label>Celular</label>
      <input type="text" name="txtCelular" placeholder="Teléfono Móvil" id="txtCelular" class="form-control"/>
 </div>
 <div class="col-md-3"><label>Email</label>
      <input type="text" name="txtEmail" placeholder="micorreo@servidor.com" id="txtEmail" class="form-control"/>
 </div>
 <div class="col-md-3"><label>Parentesco</label>
      <select name="Parentesco" id="Parentesco" class="form-control" required>
        <option value="Hijo(a)">Hijo(a)</option>
        <option value="Esposo(a)">Esposo(a)</option>
        <option value="Padre/Madre">Padre/Madre</option>
        <option value="Otro">Otro</option>
      </select>
 </div>
 <div class="col-md-3" style="display:flex;align-items:end;">
      <button class="btn btn-success" type="button" name="btnRegistrar" id="btnRegistrar">Registrar Beneficiario</button>
 </div>
</div>
</form>
</div>
<!-- Tabla visual de beneficiarios registrados -->
<div class="container-fluid" style="margin-top:30px;">
  <h5>Beneficiarios registrados</h5>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Documento</th>
          <th>Nombre completo</th>
          <th>Parentesco</th>
          <th>Fecha Nac.</th>
          <th>Celular</th>
          <th>Email</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>12345678</td>
          <td>Ejemplo Beneficiario</td>
          <td>Hijo(a)</td>
          <td>2005-01-01</td>
          <td>3001234567</td>
          <td>beneficiario@email.com</td>
          <td>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" href="#modal-Toggle2" role="button"  onclick="<?php echo $hrefEditBene; ?>"  >Editar</button>
            <button class="btn btn-sm btn-danger" disabled>Eliminar</button>
          </td>
        </tr>
        <!-- Aquí se mostrarán los beneficiarios reales -->
      </tbody>
    </table>
  </div>
</div>
<!-- ...existing code... -->
