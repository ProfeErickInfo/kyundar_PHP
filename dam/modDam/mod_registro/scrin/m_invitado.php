<html>
<head>
<title></title>
</head>

<?php  
session_start();
$Xrefer = getenv('HTTP_REFERER');  
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

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}

		
 
 


$idClub=$_GET['idClub'];


 

 $sqlInfo = mysqli_query($conexion,"select * from tbx_club  where id=".$idClub);
 $fila=mysqli_fetch_array($sqlInfo, MYSQLI_NUM);

 $CantInfo = mysqli_num_rows($sqlInfo);
 if($CantInfo<0){
	 echo"Se perdieron los datos, regrese e intentelo nuevamente";
 }else{
	 
	 
 $carpeta=$idClub;
 $nombre=$fila[1];
 $idBarrio=$fila[3];
 $dir=$fila[4];
 $entrenador=$fila[5];
 $telefono=$fila[6];
 $representante=$fila[7];
 $cel=$fila[8];
 $email=$fila[9];
 $website=$fila[10];
 $logo=$fila[11];
 $fecha=$fila[12];
 $tipo=$fila[13];
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

 <!----------------------------------------------------------------->
 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


<!-- Bootstrap ya est· cargado en el men˙ principal - Comentado para evitar conflictos
-->
<!--------------------------------------------------->


<link href="../../../faces/estilo.css" rel="stylesheet" type="text/css" />


<style type="text/css">

<!--

.Estilo9 {font-size: large}

-->

</style>
<style>

body
{
font-family:arial;
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


<!----------------------------------------------------------------------->
<!-- <body> comentado para evitar conflictos con el contenedor principal -->
<div class="container" style="color:#fff">
  


<div class="row">
  <div class="text-center mb-12">
   
  <h3>Editar informaci√≥n de Socio.</h3>
</div>
</div>
  <form name="mclub" method="POST" action="Javascript:enviarFormulario('modDam/mod_registro/ejec/mClub_invitado.php?idClub=<?=$idClub?>','mclub',1,'modDam/mod_registro/scrin/m_invitado.php?idClub=<?=$idClub?>','carga','DivContenido','');" id="mclub">
 
    <div class="row">

      <div class="form-group col-md-4"><label></label>
        <input class="form-control" name="txtNomclub" type="text" id="txtNomclub" value="<?=$nombre?>" onKeyPress="return focusNext(this.form, 'txtdireccion', event);" placeholder="Nombre del club o liga"  >
</div>
<div class="form-group col-md-4"><label></label>
  <input class="form-control" name="txtdireccion" type="text" id="txtdireccion" placeholder="Ciudad, barrio, sector."  value="<?=$dir?>"  onKeyPress="return focusNext(this.form, 'txtCorreo', event);" />
    
  
</div>
<div class="form-group col-md-4"><label></label>
  <input class="form-control" name="txtCorreo" type="text" id="txtCorreo" placeholder="nombredelcorreo@servidor.com" value="<?=$email?>" onKeyPress="return focusNext(this.form, 'txtresponsable', event);" />
</div>
    </div>
    
   
    <div class="row">
    <div class="form-group col-md-3"> <input value="<?=$representante?>" class="form-control" name="txtresponsable" type="text" id="txtresponsable" placeholder="Presidente o Delegado"  onKeyPress="return focusNext(this.form, 'txtcelular1', event);"><label></label></div>

    <div class="form-group col-md-3"><td ><input value="<?=$cel?>" class="form-control" name="txtcelular1" type="number" id="txtcelular1" placeholder="(000)000-00000"  onKeyPress="return focusNextNum(this.form, 'txtEntrenador', event);" /><label></label></div>

    <div class="form-group col-md-3"><input value="<?=$entrenador?>" class="form-control" name="txtEntrenador" type="text" id="txtEntrenador" placeholder="Nombre del Entrenador"  onKeyPress="return focusNext(this.form, 'txtCelular2', event);" ><label></label></div>
    
    <div class="form-group col-md-3"><input value="<?=$telefono?>" class="form-control" name="txtCelular2" type="number" id="txtCelular2" placeholder="Celular de contacto"  onKeyPress="return focusNextNum(this.form, 'crear_sede', event);" ><label></label></div>
    </div>




  </div>
  <br>




  
     <!------------ULTIMA FILA- (BOTONES)------------->        
     <div class="row" > 
      <div class="col-6" ><label></label> <p></p></div>
      

  <div class="col-3" align="right">   <label></label>
           
 <button class="btn btn-success" type="button" name="btnRegistrar" value="Actualizar" id="btnRegistrar"  onClick="v_club_mt(mclub);"  >Actualizar</button>

</div>

    
    <div class="col-3" align="right">   <label></label>
              
      <button class="btn btn-danger" type="button" name="btnCancelar" value="Cancelar" id="btnCancelar"  onClick="if(confirm('Deseas cancelar el registro actual?')){window.location='invitado.php';}">Regresar</button>
                                  
              
        </div>     
     
     </div>
</form>

</div>
</div>


<!------------------------------------------------------------------------>





</body>

<?php
			 } ?>
			 </html>


