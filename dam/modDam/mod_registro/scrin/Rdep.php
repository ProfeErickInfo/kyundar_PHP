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
    
include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		exit;

	}


//connexion 

	//$sqlGrados=mysqli_query($conexion,"select * from tbx_grados");

	$sqlTD=mysqli_query($conexion,"select * from tbx_tipo_documento order by descripcion");

	//$sqlGrados=mysqli_query($conexion,"select * from tbx_grados order by id");

	//$sqlLugar=mysqli_query($conexion,"select * from tbx_ciudad order by nombre");

	$sqlSexo=mysqli_query($conexion,"select * from tbx_genero limit 2");
	
	//$sqlSalud=mysqli_query($conexion,"select * from tbx_ssalud");

	//$sqlBarrio=mysqli_query($conexion,"select * from tbx_lista_barrios order by nombre");

	
  
		//VERIFICO EL METODO DE ASIGNACION DE ID_ALUMNO [AUTO] [MANUAL]

		//$sqlConfig = mysqli_query($conexion,"select auto_id_alumno from tbx_config_valores");
?>

<html>
<!----------------------------------------------------------------->
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<!-- Bootstrap ya está cargado en el menú principal - Comentado para evitar conflictos
-->
<!--------------------------------------------------->
<!-- <body> comentado para evitar conflictos con el contenedor principal -->

<!--INICIO FORM DEL REGISTRO DE FORMULARIO DEPORTISTA-->
<div class="container-fluid" style="color:#333; height: 550px; overflow: visible;"><!----------Div #1--------->

<h2 style=" text-align: left;"> Registro de Atletas<? //echo "Usuario: ".$id_usu;?></h2>
<!--------Formulario------>
<form id="formRE" name="formRE" method="post"  action="Javascript:enviarFormulario('modDam/mod_registro/ejec/RdepI.php?idusu=<?= $id_usu ?>','formRE',1,'modDam/mod_registro/scrin/Rdep.php?idusu=<?= $id_usu ?>','carga','DivContenido','txtNombres');">      
 
<div class="row"><!----------Div #2--------->

<div class="form-group col-md-3"><label>Tipo de Documento</label><!----------Div #3--------->
<select name="TipoDocumento"  id="TipoDocumento" class="form-control" required onkeypress="return focusNext(this.form,'txtDocumento',event);">
  <?php 						

					 while ($reg=mysqli_fetch_array($sqlTD, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".($reg[1])."</option>";

				}

					?>
</select>
</div><!----------Cierro Div #3--------->


<div class="form-group col-md-3"><label>NÂº Documento</label><!----------Div #4--------->
<input type="number" name="txtDocumento" required placeholder="Documento" id="txtDocumento" class="form-control" onKeyPress="return focusNextNum(this.form,'txtEmail',event);" />
</div>     <!----------Cierro Div #4--------->

                
<div class="form-group col-md-3 "> <!----------Div del Email--------->
                 
				 <label>Email.</label>

			  <input type="email" name="txtEmail" placeholder="micorreo@servidor.com" id="txtEmail" class="form-control" onKeyPress="return focusNext(this.form,'Sexo',event);" required/>
			
</div>

 <!----------Cierro div del email--------->


<div class="form-group col-md-3"><label>Genero</label><!----------Div #5--------->

<select    name="Sexo"   id="Sexo" required class="form-control" onkeypress="return focusNext(this.form,'btnRegistrar2',event);">
  <?php 						

					 while ($reg=mysqli_fetch_array($sqlSexo, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".$reg[1]."</option>";

				}

					?>
</select>
</div><!----------Cierro Div #5--------->


</div><!----------Cierro Div #2--------->



<!------------------FIN FILA UNO---------------------------------------->
<div class="row"><!----------Div #6--------->

<div class="form-group col-md-4"><label>Nombres del Deportista</label><!----------Div #7--------->
<input type="text" pattern="[a-z]" name="txtNombres" required id="txtNombres" placeholder="Nombres" class="form-control" onKeyPress="return focusNext(this.form,'txtApellidos',event);"/>
</div><!----------Cierro Div #7-------->


<div class="form-group col-md-4"><label>Apellido del Deportista</label><!----------Div #8--------->
<input type="text" pattern="[a-z]{1,15}" name="txtApellidos" required placeholder="Apellidos" id="txtApellidos" class="form-control"  onKeyPress="return focusNext(this.form,'txtFechaNac',event);"/>
</div><!----------Cierro Div #8--------->

<div class="form-group col-md-2"><label>Fecha de Nacimiento</label><!----------Div #9-------->
<input  size="12"required  placeholder="Fecha de Nacimiento d/m/aÃ±o" type="date" class="form-control"  value="<? echo(date('Y-m-d'));?>"    name="txtFechaNac"  id="txtFechaNac" onKeyPress="return focusNext(this.form,'Sexo',event);" >
</div><!----------Cierro Div #9--------->
<div class="form-group col-md-2"> 
                    <label>Celular.</label>
                    <input type="text" name="txtCelular" placeholder="Telefono Movil" id="txtCelular" class="form-control"  onKeyPress="return focusNextNum(this.form,'txtEmail',event);" required />
</div>
                    
      </div><!---------Cierro -Div #6--------->







<hr>
<div class="row"><!----------Div #10--------->
<div class="col-12 text-end" ><label></label><!----------Div #11--------->
<input type="button" name="btnRegistrar2" id="btnRegistrar2"  class="btn btn-success" value="Registrar y Actualizar" onClick="valRegApp(this.form);"/><label></label>
</div><!----------Cierro Div #11--------->
</div><!----------Cierro Div #10--------->


</form><!----------Cierro Formulario-------->



 <!----------Cierro Div #15------Div de codigo nuevo--->







</div><!----------Cierro Div #1--------->
</div>
</body>
</html>
   
  
<?
  }
?>

