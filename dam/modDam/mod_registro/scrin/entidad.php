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

<html>
<head>
<title></title>

</head>
<?php

 

 include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}

	$sqlBarrio=mysqli_query($conexion,"select * from tbx_lista_barrios order by nombre");

?>



<p></p>

 
<h5> Registro de clubes afiliados</h5>
<p></p>
<div class="container">
  <form name="regclub" method="POST"  action="Javascript:enviarFormulario('modDam/mod_registro/ejec/Gclub.php','regclub',1,'modDam/mod_registro/scrin/entidad.php','carga','opciones','');" id="regclub">
 
    
    
    <table width="95%" border="0" cellspacing="0">

    <tr>

    <td  width="30%" class="headerCampo" ><div align="left">Nombre del Club</div></td>
     <td width="1%">&nbsp;</td>
    <td width="10%" class="headerCampo" ><div align="left">Barrio</div></td>
 <td width="1%">&nbsp;</td>
    <td width="27%" class="headerCampo" ><div align="left">Dirección</div></td>
    <td width="1%">&nbsp;</td>
    <td width="30%" class="headerCampo" ><div align="left">Correo Electronico</div></td>


  </tr>

 <tr height="30px" valign="middle">
    <td  ><input class="form-control" autofocus="autofocus" name="txtNomclub" type="text" id="txtNomclub" value="" onkeypress="return focusNext(this.form, 'Barrio', event);" ></td>
<td >&nbsp;</td>
    <td  ><select  name="Barrio" id="Barrio" class="custom-select mr-sm-2" onkeypress="return focusNext(this.form,'txtdireccion',event);">
       <?php 						

					 while ($reg=mysqli_fetch_array($sqlBarrio, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".utf8_decode($reg[1])."</option>";

				}

					?>

    </select></td>
<td >&nbsp;</td>
    <td ><input class="form-control" name="txtdireccion" type="text" id="txtdireccion" value="NINGUNA"  onkeypress="return focusNext(this.form, 'txtCorreo', event);" /></td>
     <td>&nbsp;</td>
     <td ><input class="form-control" name="txtCorreo" type="text" id="txtCorreo" value="NOPRESENTO@SERVIDOR.COM" onkeypress="return focusNext(this.form, 'txtresponsable', event);" /></td>
  </tr>
<tr height="10px"><td colspan="7"></td></tr>

  
  <tr>

    <td  class="headerCampo" ><div align="left">Presidente</div></td>
    <td >&nbsp;</td>
    <td  class="headerCampo" ><div align="left">Celular/Telefono</div></td>

<td >&nbsp;</td>
    <td  class="headerCampo" ><div align="left">Entrenador</div></td>
<td >&nbsp;</td>
    <td  class="headerCampo" ><div align="left">Celular/Telefono</div></td>

  </tr>

 

  <tr height="30px" valign="middle">

    <td ><input class="form-control" name="txtresponsable" type="text" id="txtresponsable" value="" onkeypress="return focusNext(this.form, 'txtcelular1', event);"></td>
<td >&nbsp;</td>
    <td ><input class="form-control" name="txtcelular1" type="number" id="txtcelular1" value="0" onkeypress="return focusNextNum(this.form, 'txtEntrenador', event);" /></td>
<td >&nbsp;</td>
    <td ><input class="form-control" name="txtEntrenador" type="text" id="txtEntrenador" value="" onkeypress="return focusNext(this.form, 'txtCelular2', event);" ></td>
    <td >&nbsp;</td>
    <td ><input class="form-control" name="txtCelular2" type="number" id="txtCelular2" value="0" onkeypress="return focusNextNum(this.form, 'crear_sede', event);" ></td>
    

  </tr>

 

  <tr>

    <td   class="headerCampo">&nbsp;</td>
    <td>&nbsp;</td>
<td ></td>
 <td>&nbsp;</td>
<td height="60px" valign="bottom" align="right"  ><button  class="btnclass" style="visibility:hidden" type="button" name="carpeta"  id="carpeta"onClick="cargarFocus('modDam/mod_registro/ejec/pdir.php','crprueba','carga','');"  
  ><img style="vertical-align:middle" class="avatar" src="../img/nuevo_carpeta.png" width="30" height="30" >Crear Carpeta [Paso 2]</button></td>
    <td>&nbsp;</td>
<td height="70px" valign="middle" align="right" ><button class="btn btn-success" type="button" name="crear_sede"  id="crear_sede"  onclick="val_club(regclub)" ><img style="vertical-align:middle" class="avatar" src="../img/ok_verde_r.png" width="30" height="30" > Guardar Datos</button></td>
  </tr>

</table>
 
</form>
</div>




</body>
</html>

<?php
			 } ?>