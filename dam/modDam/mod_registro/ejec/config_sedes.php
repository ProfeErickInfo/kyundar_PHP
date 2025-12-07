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
include("../../../b_enlazar/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}
 

 





 //$result_ne=mysql_query("select id,detalle from nivel_escolar order by detalle" ,$schoolcontrol);

  $result_ciu=mysql_query("select id,nombre from tbx_ciudad order by nombre" ,$conexion);

  $result_B=mysql_query("select id,nombre from tbx_barrio order by nombre" ,$conexion);

  $result_sede=mysql_query("select id,nombre from tbx_sedes order by nombre" ,$conexion);

 

  $sqlInfo = mysql_query("select g.id,g.nombre,g.telefono,(select n.nombre from tbx_ciudad n where n.id=g.id_ciudad) ciu from tbx_sedes g order by g.nombre" ,$conexion);

 $sqlvacio = mysql_query("select count(id) from tbx_sedes " ,$conexion);

 $sqlsivacio=mysql_result($sqlvacio,0,0);

 if ($sqlsivacio!=0){

 

 $CantInfo = mysql_num_rows($sqlInfo);

 }else{

 $CantInfo=0;

 }

 ?>

<link type="text/css" rel="stylesheet" href="../../../faces/estilo.css">

<form name="sede" method="post"   action="Javascript:enviarFormulario('lockers/c_general/prgs/guardar_sede.php','sede',1,'lockers/c_general/wins/config_sedes.php','carga','DivContenido','txtnomsede');" id="sede">

<table width="100%" border="0" cellspacing="0">

  <tr>

    <td width="100%" class="headerForm" ><div align="left">Registro General de  Sedes </div></td>

  </tr>

  <tr>

    <td>
    
    
    <table width="100%" border="0" cellspacing="3">

    <tr>

    <td  width="40%" class="headerCampo" bgcolor="#8DD2F0"><div align="center">Nombre de la sede</div></td>
 <td width="2%">&nbsp;</td>
    <td width="28%" class="headerCampo" bgcolor="#8DD2F0"><div align="center">Ciudad</div></td>
 <td width="2%">&nbsp;</td>
    <td width="28%" class="headerCampo" bgcolor="#8DD2F0"><div align="center">Barrio</div></td>

  </tr>

  <tr>

    <td width="40%"><input class="inputTxt" name="txtnomsede" type="text" id="txtnomsede" value="" onkeypress="return focusNext(this.form, 'select_ciudad', event);" ></td>
<td width="2%">&nbsp;</td>
    <td width="28%" >

    

    <select  class="inputTxt" name="select_ciudad" id="select_ciudad"  onkeypress="return focusNext(this.form, 'select_barrio', event);">

              <?php

			            if ($row = mysql_fetch_array($result_ciu)){ 

                             

                         do { 

						 

						

                             echo '<option value= "'.$row["id"].'">'.$row["nombre"].'</option>';

							

                              } while ($row = mysql_fetch_array($result_ciu)); 

                             



                                 }

								

								

                    ?>

            </select></td>
<td width="2%">&nbsp;</td>
    <td width="28%"><select  class="inputTxt" name="select_barrio" id="select_barrio" onkeypress="return focusNext(this.form, 'txtdireccion', event);">

              <?php

			            if ($row = mysql_fetch_array($result_B)){ 

                             

                         do { 

						 

						

                             echo '<option value= "'.$row["id"].'">'.$row["nombre"].'</option>';

							

                         } while ($row = mysql_fetch_array($result_B)); 

                             



                       	}

								

								

                    ?>

            </select></td>

  </tr>

   <tr>

    <td>&nbsp;</td>
<td width="2%">&nbsp;</td>
    <td>&nbsp;</td>
<td width="2%">&nbsp;</td>
    <td>&nbsp;</td>

  </tr>

  <tr>

    <td width="40%" class="headerCampo" bgcolor="#8DD2F0"><div align="center">Direccion</div></td>
<td width="2%">&nbsp;</td>
    <td width="28%" class="headerCampo" bgcolor="#8DD2F0"><div align="center">Telefono #1</div></td>
<td width="2%">&nbsp;</td>
    <td width="28%" class="headerCampo" bgcolor="#8DD2F0"><div align="center">Telefono #2</div></td>

  </tr>

 

  <tr>

    <td width="40%"><input class="inputTxt" name="txtdireccion" type="text" id="txtdireccion" value=""  onkeypress="return focusNext(this.form, 'txttelefono', event);"></td>
<td width="2%">&nbsp;</td>
    <td width="28%"><input class="inputTxt" name="txttelefono" type="text" id="txttelefono" value="" onkeypress="return focusNext(this.form, 'txttelefono2', event);" ></td>
<td width="2%">&nbsp;</td>
    <td width="28%"><input class="inputTxt" name="txttelefono2" type="text" id="txttelefono2" value="" onkeypress="return focusNext(this.form, 'txtresponsable', event);" ></td>

  </tr>

  <tr>

    <td>&nbsp;</td>
<td width="2%">&nbsp;</td>
    <td>&nbsp;</td>
<td width="2%">&nbsp;</td>
    <td>&nbsp;</td>

  </tr>

  <tr>

    <td colspan="2" bgcolor="#8DD2F0" class="headerCampo"><div align="center">Responsable</div></td>
<td width="2%">&nbsp;</td>
    <td>&nbsp;</td>
<td width="2%">&nbsp;</td>
  </tr>

  <tr>

    <td colspan="2"><input class="inputTxt" name="txtresponsable" type="text" id="txtresponsable" value="" onkeypress="return focusNext(this.form, 'crear_sede', event);"></td>
<td width="2%">&nbsp;</td>
<td width="2%">&nbsp;</td>
    <td><div align="right">

      <input class="btnclass" type="button" name="crear_sede" value="Crear Sede" id="crear_sede"  onclick="valida_sede()" />

    </div></td>

  </tr>

</table>

</td>

  </tr>

</table>

</form>


<div id="apDivHistoryInfoAca">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <!--    <tr>

      <td >&nbsp;</td>

    </tr>

-->

    <tr>

      <td><table width="100%" border="0" cellspacing="2" cellpadding="2">

        <tr>

          <td width="484" align="center" class="headerLista" >Nombre de la Sede</td>

          <td width="5" style="width:5px;"></td>

          <td width="102" align="center" class="headerLista">Ciudad</td>

          <td width="14" style="width:5px;"></td>

          <td width="106" align="center" class="headerLista">Telefono</td>

          <td width="5" style="width:5px;"></td>

		   <td width="88" align="center" class="headerLista">Editar</td>

          

        </tr>

        <!--INICIO VISUALIZACION RESULTADO DE LA CONSULTA -->
 <?php 

  

  		$c=1;

		

  		for($j=0;$j<$CantInfo;$j++){

			

			if($c==2){

			

				$color=' class="trColor1"';

				

				$c--;

			

			}else{

			

				$color=' class="trColor2"';

				

				$c++;

			

			}

			

			

				

				

				$ImgEdit = "graficos/editar.png";

				$Href = "JavaScript:cargarFocus('lockers/c_general/wins/modificar_sedes.php?idSede=".mysql_result($sqlInfo,$j,"id")."','DivContenido','carga','');";

				$Comenta = "Clic sobre la imagen para acceder a la edicion de la informaci&oacute;n de la sede.";

			

			

  

  

  

  ?>

       

  

        <tr <?=$color?> >

          <td><?php echo @mysql_result($sqlInfo,$j,"nombre"); ?></td>

          <td></td>

          <td align="center"><?php echo @mysql_result($sqlInfo,$j,"ciu"); ?></td>

          <td></td>

          <td align="center"><?php echo @mysql_result($sqlInfo,$j,"telefono"); ?></td>

          <td></td>

          <td align="center"><a href="<?= $Href ?>" title="<?= $Comenta ?>"><img src="<?= $ImgEdit ?>" alt="" width="19" height="19" border="0" /></a></td>

        </tr>
 <?php 

  

		}

  

  ?>
       
        <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->

        <tr class="headerLista">

          <td>&nbsp;</td>

          <td></td>

          <td>&nbsp;</td>

          <td></td>

          <td>&nbsp;</td>

          <td></td>

          <td>&nbsp;</td>

         

        </tr>

      </table></td>

    </tr>

    <tr>

      <td>&nbsp;</td>

    </tr>

  </table>

</div>

<?
}
?>