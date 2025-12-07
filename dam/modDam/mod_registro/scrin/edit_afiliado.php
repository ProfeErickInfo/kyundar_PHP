<?php  
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$Xrefer = getenv('HTTP_REFERER');  
if ((!$Xrefer) || ($id_usu==0)){
	?>
     <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/sesionOut.html" />
     <?php
		exit();
}
include("../../../../enlace/conexion.php");
if (!$conexion) {
	echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";
	exit();
}
$idDep = (int)@$_GET['idDep'] or exit("El documento no se ha definido, consulte con el administrador del sistema.");
$sqlSocios = mysqli_query($conexion,"select d.id, d.docRes, d.tipoDoc, d.responsable, d.celular, d.email, d.nombres, d.film, d.apellidos, d.tipo_doc, d.tipo_lugar, d.tipo_socio, d.servsalud,  d.sexo,(select t.descripcion from trn25_tipo_documento t where d.tipo_doc=t.id) as tipoDocu, d.documento, d.fecha_nac, d.lugar_nac, (SELECT g.nombre FROM trn25_genero as g WHERE d.sexo=g.id) genero, d.barrio, d.direccion, d.nombreEps,  (SELECT s.nombre FROM trn25_ssalud as s WHERE d.servsalud=s.id) serviSalud, d.cod_int  from trn25_socios d where d.id=".$idDep);
$resultados=mysqli_fetch_array($sqlSocios, MYSQLI_ASSOC);
$sqlTD=mysqli_query($conexion,"select * from trn25_tipo_documento where tipo=1 order by descripcion");
$sqlLugar=mysqli_query($conexion,"select * from trn25_paises order by nombre");
$sqlSexo=mysqli_query($conexion,"select * from trn25_genero limit 2");
$sqlSalud=mysqli_query($conexion,"select * from trn25_ssalud");

$sqlClub=mysqli_query($conexion,"select * from trn25_organizacion order by nombre");
$sqlClub2=mysqli_query($conexion,"select * from trn25_organizacion where id=".$id_usu." order by nombre");
$reg2=mysqli_fetch_array($sqlClub2, MYSQLI_NUM);
?>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="../../libros/lib25.js"></script>
<script src="../../libros/libValid25.js"></script>
<div class="container-fluid registro-form">
<div id="carga" style="display: none; text-align: center; padding: 20px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px;">
    <i class="fas fa-spinner fa-spin"></i> Procesando registro completo, por favor espere...
</div>
<h5 style="margin-bottom: 20px;">Editar información de Socio</h5>
<form id="formME" name="formME" method="POST" action="Javascript:SendFormSocio('modDam/mod_registro/ejec/m_socio.php?idSocio=<?= $idDep?>','formME',1,'modDam/mod_registro/scrin/edit_afiliado.php?idDep=<?= $idDep?>','carga','modal1dv','');">
<div class="row">
 <div class="col-md-6"><label>Club al cual pertenece</label>
      <select autofocus class="form-select" name="nomClub" id="nomClub" onKeyPress="return focusNext(this.form,'txtNombres',event);" disabled>
        <?php  if($_SESSION['tipo_U']!=1){
            while ($reg=mysqli_fetch_array($sqlClub, MYSQLI_NUM)){
                echo "<option value=".$reg[0].">".$reg[4]."</option>";
            }
        }else{
            echo "<option value=".$reg2[0].">".$reg2[4]."</option>";
        } ?>
      </select>
 </div>
 <div class="col-md-2"><label>Tipo</label>
      <select class="form-select" name="TipoDocumento" id="TipoDocumento" onKeyPress="return focusNext(this.form,'txtDocumento',event);" required>
        <?php while ($reg=mysqli_fetch_array($sqlTD, MYSQLI_NUM)){
            if($resultados["tipo_doc"]==$reg[0]){
                echo "<option value=".$reg[0]." selected>".$reg[3]."</option>";
            }else{
                echo "<option value=".$reg[0].">".$reg[3]."</option>";
            }
        } ?>
      </select>
 </div>
 <div class="col-md-2"><label>Número</label>
      <input type="number" name="txtDocumento" placeholder="Documento" id="txtDocumento" class="form-control" onKeyPress="return focusNextNum(this.form,'txtFechaNac',event);" value="<?=$resultados["documento"]?>" required />
 </div>
 <div class="col-md-2"><label>Genero</label>
      <select name="Sexo" id="Sexo" class="form-control" onKeyPress="return focusNext(this.form,'Barrio',event);" required>
        <?php while ($reg=mysqli_fetch_array($sqlSexo, MYSQLI_NUM)){
            if($resultados["sexo"]==$reg[0]){
                echo "<option value=".$reg[0]." selected>".$reg[1]."</option>";
            }else{
                echo "<option value=".$reg[0].">".$reg[1]."</option>";
            }
        } ?>
      </select>
 </div>
</div>
<div class="row">
 <div class="col-md-3"><label>Nombre (s)</label>
      <input type="text" name="txtNombres" id="txtNombres" placeholder="Nombres" class="form-control" onkeydown="return sololetras(event,'txtNombres')" onKeyPress="return focusNext(this.form,'txtApellidos',event);" value="<?=$resultados["nombres"]?>"/>
 </div>
 <div class="col-md-3"><label>Apellido (s)</label>
      <input type="text" name="txtApellidos" placeholder="Apellidos" id="txtApellidos" class="form-control" onkeydown="return sololetras(event,'txtApellidos')" onKeyPress="return focusNext(this.form,'TipoDocumento',event);" value="<?=$resultados["apellidos"]?>"/>
 </div>
 <div class="col-md-3"><label>Fecha de Nacimiento</label>
      <input size="12" placeholder="00/00/0000" type="date" value="<?=$resultados["fecha_nac"]?>" name="txtFechaNac" class="form-control" id="txtFechaNac" onKeyPress="return focusNext(this.form,'LugarNac',event);" required />
 </div>
 <div class="col-md-3"><label>Lugar de Nacimiento</label>
      <select name="LugarNac" id="LugarNac" class="form-control" onKeyPress="return focusNext(this.form,'Sexo',event);" required>
        <?php while ($reg=mysqli_fetch_array($sqlLugar)){
            if($resultados["lugar_nac"]==$reg['id']){
                echo "<option value=".$reg['id']." selected>".$reg['nombre']."</option>";
            }else{
                echo "<option value=".$reg['id'].">".$reg['nombre']."</option>";
            }
        } ?>
      </select>
 </div>
</div>
<div class="row">
 <div class="col-md-3"><label>Barrio</label>
      <input type="text" name="Barrio" id="Barrio" class="form-control" value="<?=$resultados["barrio"] ?>" onKeyPress="return focusNext(this.form,'txtDireccion',event);" required />
 </div>
 <div class="col-md-3"><label>Dirección</label>
      <input type="text" name="txtDireccion" placeholder="Dirección" id="txtDireccion" class="form-control" onKeyPress="return focusNext(this.form,'Tpsalud',event);" required value="<?=$resultados["direccion"]?>" />
 </div>
 <div class="col-md-3"><label>Tipo. Serv</label>
      <select name="Tpsalud" id="Tpsalud" class="form-control" onKeyPress="return focusNext(this.form,'txtSalud',event);" required>
        <?php while ($regSalud=mysqli_fetch_array($sqlSalud, MYSQLI_NUM)){
            if($resultados["servsalud"]==$regSalud[0]){
                echo "<option value=".$regSalud[0]." selected>".$regSalud[1]."</option>";
            }else{
                echo "<option value=".$regSalud[0].">".$regSalud[1]."</option>";
            }
        } ?>
      </select>
 </div>
 <div class="col-md-3"><label>Serv. de salud</label>
      <input type="text" name="txtSalud" placeholder="Escribe tu EPS " id="txtSalud" class="form-control" onKeyPress="return focusNext(this.form,'txtCelular',event);" required value="<?=$resultados["nombreEps"]?>" />
 </div>
</div>
<div class="row">
 <div class="col-md-6">
  <div style="font-weight:bolder">Tipo de Socio Registrado</div>
  <div class="form-check form-check-inline">
   <input class="form-check-input" type="radio" value="1" <?php echo ($resultados["tipo_socio"]==1) ? 'checked' : '';?> name="OpSocio" onClick="javascript:nohabilita()" required>
   <label class="form-check-label" for="flexRadioDefault1">Socio Afiliado</label>
  </div>
  <div class="form-check form-check-inline">
   <input type="radio" value="2" class="form-check-input" <?php echo ($resultados["tipo_socio"]==2) ? 'checked' : '';?> name="OpSocio" onClick="javascript:habilita()" required>
   <label class="form-check-label" for="flexRadioDefault1">Socio Deportista</label>
  </div>
 </div>
 <div class="col-md-3"><label>Celular</label>
      <input type="text" name="txtCelular" placeholder="Telefono Movil" id="txtCelular" class="form-control" value="<?=$resultados["celular"]?>" onKeyPress="return focusNextNum(this.form,'txtEmail',event);" required />
 </div>
 <div class="col-md-3"><label>Email</label>
      <input type="text" name="txtEmail" placeholder="micorreo@servidor.com" id="txtEmail" value="<?=$resultados["email"]?>" class="form-control" onKeyPress="return focusNext(this.form,'btnRegistrar',event);" required />
 </div>
</div>
<hr>
<div class="row">
 <div class="col-auto" style="align-content: end;">
  <button class="btn btn-success" type="button" name="btnRegistrar" value="Actualizar" id="btnRegistrar" onClick="valid_socio_m(this.form);">Actualizar</button>
 </div>
</div>
</form>
</div>


