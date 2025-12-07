<?PHP
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$Xrefer = getenv('HTTP_REFERER');  
if ((!$Xrefer) || ($id_usu==0)){
	?>
     <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/sesionOut.html" />
     <?php
		exit();
	}else{
    // Se ejecuta el ajax normalmente  
 
?>  

<?php 

	include("../../../../enlace/conexion.php"); 
	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}


//connexion 

	$sqlGrados=mysqli_query($conexion,"select * from tbx_grados");

	$sqlTD=mysqli_query($conexion,"select * from tbx_tipo_documento order by descripcion");

	$sqlGrados=mysqli_query($conexion,"select * from tbx_grados order by id");

	$sqlLugar=mysqli_query($conexion,"select * from tbx_ciudad order by nombre");

	$sqlSexo=mysqli_query($conexion,"select * from tbx_sexo");
	
	$sqlSalud=mysqli_query($conexion,"select * from tbx_ssalud");

	$sqlBarrio=mysqli_query($conexion,"select * from tbx_lista_barrios order by nombre");

	

		//VERIFICO EL METODO DE ASIGNACION DE ID_ALUMNO [AUTO] [MANUAL]

		$sqlConfig = mysqli_query($conexion,"select auto_id_alumno from tbx_config_valores");

		//$autoId = @mysql_result($sqlConfig,0,"auto_id_alumno");

	

		

	$CantTD = mysqli_num_rows($sqlTD);

	$CantGr = mysqli_num_rows($sqlGrados);

	$CantLug = mysqli_num_rows($sqlLugar);

	$CantSexo = mysqli_num_rows($sqlSexo);
	
	$CantSalud=mysqli_num_rows($sqlSalud);

	$CantBarrio = mysqli_num_rows($sqlBarrio);	



?>








    <!--INICIO FORM DEL REGISTRO DE FORMULARIO ASPIRANTES -->

    

<form id="formRE" name="formRE" method="post"  action="Javascript:enviarFormulario('modDam/mod_registro/ejec/RdepApp.php?idusu=<?= $id_usu ?>','formRE',1,'modDam/mod_registro/scrin/regApp.php?idusu=<?= $id_usu ?>','carga','DivContenido','txtNombres');">      

<div class="form-label-group">
<select name="TipoDocumento" id="TipoDocumento" class="form-control" onkeypress="return focusNext(this.form,'txtDocumento',event);">
  <?php 						

					 while ($reg=mysqli_fetch_array($sqlTD, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".$reg[1]."</option>";

				}

					?>
</select>
</div>
<div class="form-label-group">
<input type="number" name="txtDocumento" placeholder="Documentos" id="txtDocumento" class="form-control" onKeyPress="return focusNextNum(this.form,'txtFechaNac',event);" />
</div>     
<div class="form-label-group">
<input type="text" name="txtNombres" id="txtNombres" placeholder="Nombres" class="form-control" onkeydown="return sololetras(event,'txtNombres')" onKeyPress="return focusNext(this.form,'txtApellidos',event);"/>
</div>

<div class="form-label-group">
<input type="text" name="txtApellidos" placeholder="Apellidos" id="txtApellidos" class="form-control"  onkeydown="return sololetras(event,'txtApellidos')" onKeyPress="return focusNext(this.form,'txtFechaNac',event);"/>
</div>

<div class="form-label-group">
<div style="float:left; width:49%; display:block">
<input  size="12" placeholder="00/00/0000" type="date" class="form-control"  value="<? echo(date('Y-m-d'));?>"     name="txtFechaNac"  id="txtFechaNac" >
</div>
<div style="float:right; width:49%; display:block">

<select    name="Sexo" id="Sexo" class="form-control" onkeypress="return focusNext(this.form,'btnRegistrar2',event);">
  <?php 						

					 while ($reg=mysqli_fetch_array($sqlSexo, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".$reg[1]."</option>";

				}

					?>
</select>
</div>
</div>

<input type="button" name="btnRegistrar2" id="btnRegistrar2" style="background-color:#800; color:#FFF"  class="btn btn-secondary my-2" value="Registrar y Actualizar" onClick="valRegApp(this.form);"/>
</form>
	
<?
}
?>


