<?php  
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

<html>
<head>
<title></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<!----------------------------------------------------------------->
 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


<!-- Bootstrap ya est· cargado en el men˙ principal - Comentado para evitar conflictos
-->
<!--------------------------------------------------->
</head>


<?php

 

 include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}

		$sqlBarrio=mysqli_query($conexion,"select * from tbx_lista_barrios order by nombre");
//@$CantBarrio = mysqli_num_rows($sqlBarrio);	

 
 


$idClub=$_GET['idClub'];


 

 $sqlInfo = mysqli_query($conexion,"select * from tbx_club  where id=".$idClub);
 $fila=mysqli_fetch_array($sqlInfo);

 $CantInfo = mysqli_num_rows($sqlInfo);
 if($CantInfo<0){
	 echo"Se perdieron los datos, regrese e intentelo nuevamente";
 }else{
	 
	 
 $carpeta=$idClub;
 $nombre=$fila['nombre'];
 $idBarrio=$fila['id_barrio'];
 $dir=$fila['direccion'];
 $entrenador=$fila['entrenador'];
 $telefono=$fila['telefono'];
 $representante=$fila['representante'];
 $cel=$fila['cel'];
 $email=$fila['email'];
 $website=$fila['website'];
 $logo=$fila['escudo'];
 $fecha=$fila['fec_reg'];
 $tipo=$fila['tipo_U'];
  $logo2='sub_img/uploads/'.$carpeta.'/'.$logo;
 }
 


 
/*
 $sqlvacio = mysql_query("select count(id) from tbx_institucion " ,$conexion);

 $sqlsivacio=mysql_result($sqlvacio,0,0);

 if ($sqlsivacio!=0){

 

 

 }else{

 $CantInfo=0;

 }
*/

 ?>

 



<style type="text/css">

<!--

.Estilo9 {font-size: large}

-->

</style>
<style>

body
{
font-family:arial;
background-color:#FFFFFF;
}
.preview
{
width:200px;
border:solid 1px #dedede;
padding:10px;
}
#preview
{
color:#cc0000;
font-size:12px
}

</style>
<script type="text/javascript" >
 $(document).ready(function() { 
		
            $('#photoimg').live('change', function()			{ 
			           $("#preview").html('');
			    $("#preview").html('<img src="loader.gif" alt="Uploading...."/>');
			$("#imageform").ajaxForm({
						target: '#preview'
		}).submit();
		
			});
        }); 
</script>


<!-- <body> comentado para evitar conflictos con el contenedor principal -->

<!--FINAL FORM DEL REGISTRO DE FORMULARIO DEPORTISTA-->
<div class="d-flex bd-highlight">
	
<div class="p-2 flex-fill bd-highlight" >


<form name="modclub" method="POST" action="Javascript:enviarFormulario('modDam/mod_registro/ejec/Mclub.php?idClub=<?=$idClub?>','modclub',0,'modDam/mod_registro/scrin/m_entidad.php?idClub=<?=$idClub?>','carga','opciones','');" id="modclub">
<!------------FILA CERO-------------->  
<!------------0--------------> 
<p class="h5">Estas editando un club</p>
 <div class="form-row">
            
  <div class="form-group col-md-3">
<label>Nombre del Club</label><input class="form-control" name="txtNomclub" type="text" id="txtNomclub" value="<?=$nombre?>" onKeyPress="return focusNext(this.form, 'Barrio', event);" >
</div>
</div>

<!------------PRIMERA FILA-------------->  
<!------------1-A --------------> 
    <div class="form-row">
         <div class="form-group col-md-3">
 <label>Barrio</label>
 <select name="Barrio" id="Barrio" class="form-control" onkeypress="return focusNext(this.form,'txtdireccion',event);">
       <?php 						
   						

					 while ($reg=mysqli_fetch_array($sqlBarrio, MYSQLI_NUM)){
if($idBarrio==$reg[0]){					
					echo "<option selected='selected'  value=".$reg[0].">".utf8_decode($reg[1])."</option>";
}else{
	echo "<option  value=".$reg[0].">".utf8_decode($reg[1])."</option>";
}

				}

					?>

    </select>
    </div>   
  
<!------------2-A --------------> 
 
 <div class="form-group col-md-3">
 <label>Direcci√≥n</label>
 <input class="form-control" name="txtdireccion" type="text" id="txtdireccion" value="<?=$dir?>"  onkeypress="return focusNext(this.form, 'txtCorreo', event);" />
 </div>
 
 
 <!------------3-A --------------> 
 
 <div class="form-group col-md-3">

  <label>Correo Electronico</label>
  <input class="form-control" name="txtCorreo" type="email" id="txtCorreo" value="<?=$email?>" onKeyPress="return focusNext(this.form, 'txtresponsable', event);" />
 
 
 
 </div>
 </div>

<!------------SEGUBDA FILA-------------->  
<!------------1-B --------------> 
 <div class="form-row">
         <div class="form-group col-md-3">
 <label>Presidente</label>
 <input class="form-control" name="txtresponsable" type="text" id="txtresponsable" value="<?=$representante?>" onKeyPress="return focusNext(this.form, 'txtcelular1', event);">
 
 
 </div>
 <div class="form-group col-md-3">
 <label>Celular/Telefono</label>
 <input class="form-control" name="txtcelular1" type="number" id="txtcelular1" value="<?=$cel?>" onKeyPress="return focusNextNum(this.form, 'txtEntrenador', event);" />
 
 
 </div>
  <div class="form-group col-md-3">
 <label>Entrenador</label>
 <input class="form-control" name="txtEntrenador" type="text" id="txtEntrenador" value="<?=$entrenador?>" onKeyPress="return focusNext(this.form, 'txtCelular2', event);" >
 
 
 </div>
 
 <div class="form-group col-md-3">
 <label>Celular/Telefono</label>
 <input class="form-control" name="txtCelular2" type="number" id="txtCelular2" value="<?=$telefono?>" onKeyPress="return focusNextNum(this.form, 'crear_sede', event);" >
 
 
 </div>
 </div>
 <!------------TERCERA FILA-------------->  
<!------------1-C --------------> 
 <div class="form-row">
         <div class="form-group col-md-3">
 <button type="button" class="btn btn-warning"  name="crear_sede" id="crear_sede"  onClick="mostrar('DvOpciones2');grupoFocus('modDam/mod_registro/scrin/head_lista_club.html','DvOpciones2','carga','','modDam/mod_registro/scrin/lista_club.php','opciones');" >Regresar a la lista</button>
  </div>
 
 <div class="form-group col-md-3">
 <button class="btn btn-primary" type="button" name="crear_sede" value="Actualizar" id="crear_sede"  onclick="val_club(modclub)" >Actualizar</button>
 </div>
 </div>
 
 
</form>




</div>

<div id="DVsub" class="p-2 flex-fill bd-highlight">
    <div id="preview" style="height:230px; width:220px; background:#FFFFFF ; vertical-align:middle;" ><img src=<?=$logo2?>  id="FotoPerfil" style="width:200px; height:200px"/></div>
    
  <div class="custom-file">
    <form id="imageform" name="imageform" method="post" enctype="multipart/form-data" action='sub_img/ajaximage2.php?idc=<?=$idClub?>'>
   
    <input type="file"  class="custom-file-input"  name="photoimg" id="photoimg" value=<?=$logo?> accept="image/*" capture="camera" />
    <label class="custom-file-label" for="photoimg">Subir</label>
 
  </form>
  
 
  
	<b>Mi Escudo</b></div>
     </div>
<div>



</body>
</html>

<?php
			 } ?>

