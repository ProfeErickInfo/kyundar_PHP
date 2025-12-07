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
     include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	} 
	
	$sqlGrupos=mysql_query("select * from tbx_grupos",$conexion);
	
	//$CantGr = mysql_num_rows($sqlGrados);
	
			$link="lista_general";
			$link2="lista_asistencia";
$ano="1";
?>

<link type="text/css" rel="stylesheet" href="../../../faces/estilo.css">



<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Geneva, sans-serif;
	font-weight: bold;
	font-size: 10px;
}
-->
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td class="headerForm">Gestionar Consultas Generales</td>
  </tr>
  
  <tr>
    <td style="height:10px;"></td>
  </tr>
  
  <tr>
    <td>
    
    <!--INICIO TABLA VALIDACION ASPIRANTES -->
    
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10%" align="center" style="padding-left:10px;" class="headerCampo">Seleccione el Grupo</td>
        <td width="1%" >&nbsp;</td>
        <td width="15%" align="center">
        
       	
		<select name="GruposP" id="GruposP" class="inputTxt" >
		
          <?php
		  //onChange="JavaScript:cargarVentanaReport('modulos/reportesygraficas/iframe.php?idPer=1&h=500&url=modulos/reportesygraficas/controlador/lista_general.php?', 'apDivCuerpoVentana', 'apDiv2', 'apDivVentana', 'apDivBarraTitulo', 'Reporte de Informaci&oacute;n Acad&eacute;mica Periodo 1', 'TblVentana', 800, 500,'GruposP');" title="1"
				echo "<option value='-1'>Seleccione el Grupo</option>";
				
				while ($reg=mysql_fetch_array($sqlGrupos)){
					
					echo "<option value=".$reg['id'].">".$reg['nombre']."</option>";
				}
			?>
        </select>        </td>
        <td width="1%">&nbsp;</td>
        <td width="15%" align="center"><input name="btnDane" type="button" value="Info General" class="btnclass" align="center" onclick="cargarFocus('lockers/b_reportes/iframe.php?h=500&url=lockers/b_reportes/prgs/lista_dane.php?','apDivListaValAsp','carga','GruposP');" /></td>
    <td width="1%">&nbsp;</td>
        <td width="9%" align="center" ><input name="btnDane" type="button" value="Exportar a Excel" class="btnclass" align="center" onclick="cargarFocus('lockers/b_reportes/prgs/lista_excel.php?idper=1&orden='+document.getElementById('GruposP').value+'&idgrupo='+document.getElementById('GruposP').value,'apDivListaValAsp','carga','GruposP');" /></td>
		
		
		
		<td width="1%" >&nbsp;</td>
        <td width="15%"  align="center"  ><input name="btnlista" type="button" value="Lista Por Club"  class="btnclass" onclick="cargarFocus('lockers/b_reportes/iframe.php?h=500&url=lockers/b_reportes/prgs/<?=$link?>.php?vbusca='+GruposP.value,'apDivListaValAsp','carga','GruposP');"/></td>
       <td width="1%" >&nbsp;</td>
        <td width="15%"  align="center" ><input name="btnAsistencia" type="button" value="Listas de  Ranking" class="btnclass" onclick="cargarFocus('lockers/b_reportes/iframe.php?h=500&url=lockers/b_reportes/prgs/<?=$link2?>.php?vbusca='+GruposP.value,'apDivListaValAsp','carga','GruposP');" /></td>
        
		<td width="1%" >&nbsp;</td>
        <td width="15%"  align="center"  ><input name="btnlista" type="button" value="Por Evento Local"  class="btnclass" onclick="cargarFocus('lockers/b_reportes/iframe.php?h=500&url=lockers/b_reportes/prgs/lista_estudir.php?vbusca='+GruposP.value,'apDivListaValAsp','carga','GruposP');"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="height:10px;"></td>
  </tr>
  <tr>
    <td><div class="Estilo1" id="apDivListaValAsp">1. Inicia la Consulta Seleccionando el Grupo para la Solicitud.</div></td>
  </tr>
</table> 
    
    <!--FINAL TABLA VALIDACION ASPIRANTES -->
    
    </td>
  </tr>
</table>
<?
}
?>