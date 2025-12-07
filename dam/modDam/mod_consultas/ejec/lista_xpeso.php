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



	$opbusca = 1;
	$pes = $_GET['pes'];
	$niv = $_GET['niv'];
    $cat = $_GET['cat'];
	$orden1 = $_GET['orden1'];
	
	 
	//echo "el orden es1: ".$orden1;
	
    
	$OrderBy = $_GET['orden1'];

////////////////combinaciones para todas las categorias	
if(($cat==0)&&($pes==0)&&($niv==0)){
 $Query = "select * from tbx_deportistas a order by ".$OrderBy;
}
//////////////////////////////////////////////////////////
if(($cat==0)&&($pes==0)&&($niv!=0)){
	if($niv!=2){
		
 $Query = "select * from tbx_deportistas where id_grado BETWEEN 1 AND 3 order by ".$OrderBy;
	}else if($niv!=3){
 $Query = "select * from tbx_deportistas where id_grado BETWEEN 4 AND 6 order by ".$OrderBy;
	}elseif($niv!=4){
 $Query = "select * from tbx_deportistas where id_grado=7 order by ".$OrderBy;
	}
}
////////////////////////////////////////////
if(($cat!=0)&&($pes!=0)&&($niv!=0)){
	if($niv!=2){
		$sqlPeso=mysqli_query($conexion,"select * from tbx_pesos where id=".$pes);
		 $regPeso=mysqli_fetch_array($sqlPeso, MYSQLI_NUM);
		 $ini= $regPeso[4];
		 $fin= $regPeso[5];
		 
		 
 $Query = "select * from tbx_deportistas where id_cat=".$cat." and peso BETWEEN ".$ini." AND ".$fin." and  id_grado BETWEEN 1 AND 3 order by ".$OrderBy;
	}else if($niv!=3){
 $Query = "select * from tbx_deportistas where id_cat=".$cat." and peso BETWEEN ".$ini." AND ".$fin." and  id_grado BETWEEN 4 AND 6 order by ".$OrderBy;
	}elseif($niv!=4){
 $Query = "select * from tbx_deportistas where id_cat=".$cat." and peso BETWEEN ".$ini." AND ".$fin." and  id_grado=7 order by ".$OrderBy;
	}
}

/////////////////////////////////////////////////////////
if(($cat!=0)&&($pes!=0)&&($niv==0)){
if($niv!=2){
		$sqlPeso=mysqli_query($conexion,"select * from tbx_pesos where id=".$pes);
		 $regPeso=mysqli_fetch_array($sqlPeso, MYSQLI_NUM);
		 $ini= $regPeso[4];
		 $fin= $regPeso[5];
		 
		 
 $Query = "select * from tbx_deportistas where id_cat=".$cat." and peso BETWEEN ".$ini." AND ".$fin."  order by ".$OrderBy;
	}else if($niv!=3){
 $Query = "select * from tbx_deportistas where id_cat=".$cat." and peso BETWEEN ".$ini." AND ".$fin."  order by ".$OrderBy;
	}elseif($niv!=4){
 $Query = "select * from tbx_deportistas where id_cat=".$cat." and peso BETWEEN ".$ini." AND ".$fin." order by ".$OrderBy;
	}
}
////////////////////////////////////////////////////////


	
	
	
	

	

	//consulto año lectivo
		//$consu_ano=mysql_query("select * from tbx_anos_lectivos" ,$conexion);
        //$actual= (int) mysql_result($consu_ano,0,"ano_actual");
        //$abierto=(int) mysql_result($consu_ano,0,"ano_abierto");
      
		

		

		

	$sqlDep=mysqli_query($conexion,$Query);

	

	@$CantDep = mysqli_num_rows($sqlDep);

	

	

	if($CantDep!=0){

		

?>





  <table width="100%"  >
  
  <tr>
<th colspan="5" style="height:50px; background-color:#333; vertical-align:middle; font:'Arial Black', Gadget, sans-serif; color: #FFF; font-size:20px; font-weight:bolder; padding-left:30px; ">
 Datos del Deportistas</th></tr>

    <!--INICIO VISUALIZACION RESULTADO DE LA CONSULTA -->


    <?php 

  

  		$c=1;
//$row = mysqli_fetch_assoc($result)
		
 while ($fila=mysqli_fetch_assoc($sqlDep)){
  		//for($i=0;$i<$CantAsp;$i++){

			

							$ImgEdit = "imag/editar.png";

				$Href = "JavaScript:cargarFocus('nucleo/registro/scrin/edit_deportista.php?docuAsp=".$fila['id']."','DivContenido','carga','txtNombres');";

				$Comenta = "Clic aqui para acceder a la edici&oacute;n del deportista.";

			

			//}

  if($c==2){

			

				$color=' class="trColor1"';

				

				$c--;

			

			}else{

			

				$color=' class="trColor2"';

				

				$c++;

			

			}
			
if(file_exists($fila['id_club'])){
$ruta1="sub_img/uploads/".$fila['id_club'].'/'.$fila['film'];
}else{
$ruta1="sub_img/uploads/0.png";
	
}
  ?>


    <tr class="headerCampo">

      <td style="border-bottom-style:dotted; border-bottom-color:#CCC; border-bottom-width:4px; " rowspan="3" width="5%" align="center" valign="middle"><?php echo "<img src=".$ruta1."  width='80 height='80' />";?></td>

      <td width="20%">N: <?php echo $fila['nombres']; ?></td>
      <td width="20%"><?php  $sqlbarrio = mysqli_query($conexion, "select * from tbx_club where id=".$fila['id_Club']);
	    $reg=mysqli_fetch_array($sqlbarrio, MYSQLI_NUM);
	  
	  echo $reg[1]; ?></td>
   <td width="20%">Categoria: <?php
   $aini=date("Y");
   $afin= substr($fila['fecha_nac'], 0,4);
  $aini=(int)$aini;
  $afin=(int)$afin;
  $edad=$aini-$afin;
 
   
     $sqlCate = mysqli_query($conexion, "select * from tbx_categoria where gen=".$fila['sexo']." and ".$edad." BETWEEN edinicio and edfin");
	    $reg_C=mysqli_fetch_array($sqlCate, MYSQLI_NUM);
	  
	  echo $reg_C[1]; ?> </td>
   <td width="20%">Barrio: <?php  $sqlBarrio = mysqli_query($conexion, "select * from tbx_lista_barrios where id=".$fila['barrio']);
	    $reg_B=mysqli_fetch_array($sqlBarrio, MYSQLI_NUM);
	  
	  echo $reg_B[1]; ?></td>
    </tr>
    <tr  class="headerCampo" ><td>A: <?php echo $fila['apellidos']; ?></td>
    <td>Peso: <?php echo $fila['peso']; ?> </td>
    <td>Grado: <?php  $sqlGrado = mysqli_query($conexion, "select * from tbx_grados where id=".$fila['id_grado']);
	    $reg_G=mysqli_fetch_array($sqlGrado, MYSQLI_NUM);
	  
	  echo $reg_G[1]; ?></td>
    <td>Tel: <?php echo $fila['celular']; ?> </td></tr>
    <tr  height="40px" >
    <td colspan="4" style="border-bottom-style:dotted; border-bottom-color:#CCC; border-bottom-width:4px; " ></td></tr>


    <?php 

  

		}

  

  ?>

    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->
    
<tr class="headerCampo" >
 <td colspan="3">Total Atletas:<?php echo $CantDep; ?></td>
 <td></td>
<td></td>
</tr>

  
  </table>

 

  

<?php



	}else{

		
echo "Los datos no coinciden, intentelo nuevamente.";


	

	}

}

?>
