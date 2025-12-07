 <?php 
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
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



 include("../../../../../../enlace/conexion.php");
	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}


	$opbusca = $_GET['opbusca'];
	$OrderBy = $_GET['oby']=='' ? 'nombres, apellidos' : $_GET['oby'];
    $vBusca = $_GET['vbusca'];
    $actual= 2019;
    $abierto=2019;
		
		
	if($vBusca!=" " && $opbusca==1){
		

		$Query = "select a.id, a.nombres, a.apellidos, a.cod_int, (select g.nombre from tbx_grados g where g.id=a.id_grado) grado, a.documento from tbx_deportistas a where a.id_grado=".$vBusca." and a.id_Club=".$id_usu." order by ".$OrderBy;

		


	}elseif($vBusca!=" " && $opbusca==3){

		

		$Query = "select a.id, a.nombres, a.apellidos, a.cod_int, (select g.nombre from tbx_grados g where g.id=a.id_grado) grado, a.documento from tbx_deportistas a where a.documento =".$vBusca."  and a.id_Club=".$id_usu."  order by ".$OrderBy;

		

	}elseif($vBusca!=" " && $opbusca==2){

		

		
$Query = "select a.id, a.nombres, a.apellidos, a.cod_int, a.documento from tbx_deportistas a where  a.id_Club=".$id_usu." and concat(nombres,' ',apellidos) like '%".$vBusca."%'";
		

	}elseif($vBusca==0 && $opbusca!=1){
	$Query = "select a.id, a.nombres, a.apellidos, a.cod_int, (select g.nombre from tbx_grados g where g.id=a.id_grado) AS grado, a.documento from tbx_deportistas  a  where  a.id_Club=".$id_usu." order by ".$OrderBy;
	
	
	
}
	
     $sqlAth = mysqli_query($conexion, $Query);
	
	$CantAth = mysqli_num_rows($sqlAth);

		

	if($CantAth!=0){



?>



<link type="text/css" rel="stylesheet" href="../../../faces/estilo.css">



<form name="myform" id="myform">

  <!------------------------------------------------->
  <table class="table" width="100%" border="0" >
<tbody>
        <!--INICIO VISUALIZACION RESULTADO DE LA CONSULTA -->

        <?php 

  

  		$c=1;

		

  		 while ($fila=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC)){
  ?>

        <tr <?=$color?> >

          <td width="10%" align="center"><input type="checkbox" name="idAsA"  id="idAsA" value="<?php echo mysql_result($sqlAsp,$i,"id"); ?>"  <?php if($autoId==0){ ?>onclick="activeCheck('id_alumno_<?php echo mysql_result($sqlAsp,$i,"id"); ?>');"<?php } ?> /></td>

          <td width="1%" style="width:5px;"></td>

          <td width="30%"><?php echo $fila['nombres']; ?></td>

          <td width="1%"></td>

          <td width="30%"><?php echo$fila['apellidos']; ?></td>

          <td></td>

          <td width="10%"><?php echo (int)$fila['cod_int']; ?></td>
          
           <td width="1%"></td>

          <td width="17%"></td>

        </tr>

        <?php 

  

		}

  

  ?>

        <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->

        <tr class="headerLista">

          <td class="headerLista" align="center"><input type="checkbox" name="todo2" onclick="if(this.checked==1){seleccionar_todo('myform');}else{deseleccionar_todo('myform');}" /></td>

          <td style="width:5px;"></td>

          <td><input type="checkbox" name="idAsA2"  value="0" style="visibility:hidden" /></td>

          <td></td>

          <td>&nbsp;</td>

          <td></td>

          <td>&nbsp;</td>
           <td></td>

          <td>&nbsp;</td>

        </tr>
</tbody>
      </table>

  
  
  
  
  
  

</form>

<br />

<?php



	}else{

		

		echo "1. Consulte Seleccionando el Grupo. - 2. Consulte Digitando el Nombre o Apellido del Estudiante.";

	

	}


}
?>
 <td width="10%" class="tdClassMnuOpciones" align="center" onclick="JavaScript:cargarFocusReporteChk('lockers/b_reportes/iframe.php?idPer=<?=mysql_result($sqlPeriodo,$i,"id")?>&h=500&url=lockers/b_reportes/prgs/'+document.getElementById('idBoletin').value+'.php?', 'apDivListaValAsp','carga', '');" title="<?=mysql_result($sqlPeriodo,$i,"periodos")?>">

			  

			  			<?='Per.'.mysql_result($sqlPeriodo,$i,"id")?>
