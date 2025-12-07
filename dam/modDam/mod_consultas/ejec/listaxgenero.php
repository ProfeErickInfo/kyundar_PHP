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
	$clb = $_GET['clb'];
	$gen = $_GET['gen'];
    //$cat = $_GET['cat'];
	
	$orden1 = "id_club";
	
	 
	//echo "Datos: ".$clb."-".$gen;
	
    
	$OrderBy = $orden1;

////////////////combinaciones para todas las categorias	
if(($clb==0)&&($gen==0)){
 $Query = "select * from tbx_deportistas order by ".$OrderBy;
}
//////////////////////////////////////////////////////////
if(($clb==0)&&($gen!=0)){
	
 $Query = "select * from tbx_deportistas where sexo=".$gen." order by ".$OrderBy;
	
	
}
////////////////////////////////////////////
if(($clb!=0)&&($gen!=0)){
	$Query = "select * from tbx_deportistas where id_club=".$clb." and sexo=".$gen." order by ".$OrderBy;
}

/////////////////////////////////////////////////////////
////////////////////////////////////////////
if(($clb!=0)&&($gen==0)){
	$Query = "select * from tbx_deportistas where id_club=".$clb."  order by ".$OrderBy;
	
}

/////////////////////////////////////////////////////////
//echo "Consulta: ".$Query;
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

		

		echo "Datos no coinciden";

	

	}

}

?>
