<?php  
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
//echo "*".$id_usu;
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






  <table width="100%" class="table">
<thead style="visibility:hidden">
    <tr  style="text-align:center">

      <th  ></th>
      <th  ></th>
      <th  ></th>
      <th  ></th>
      <th  ></th>
    </tr>
</thead>
    <!--INICIO VISUALIZACION RESULTADO DE LA CONSULTA -->

    <?php 

  

  		$c=1;

		
 while ($fila=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC)){
					//echo "".$fila[0]."-".$fila[1]."";

				//}
  		//for($i=0;$i<$CantAth;$i++){

			

			if($c==2){

			

				$color=' class="trColor1"';

				

				$c--;

			

			}else{

			

				$color=' class="trColor2"';

				

				$c++;

			

			}

			

			

				

				$ImgEdit = "imag/abrir.png";
				$ImgEdit_g = "imag/gradoMas.png";
				$ImgEdit_f = "imag/subir_foto.png";
				

				$Href = "JavaScript:cargarFocus('modDam/mod_registro/scrin/edit_deportista.php?docuAsp=".$fila['id']."','DivContenido','carga','txtNombres');";

$Href_g = "JavaScript:cargarFocus('modDam/mod_registro/scrin/grados.php?idDep=".$fila['id']."','DivContenido','carga','');";

$Href_f = "JavaScript:cargarFocus('modDam/mod_registro/scrin/foto_estu.php?idDep=".$fila['id']."','DivContenido','carga','');";


				$Comenta = "Clic aqui para acceder a la informaci&oacute;n del deportista.";

$Comenta_g = "Clic aqui para acceder a la informaci&oacute;n de los grados o ascensos.";
		$Comenta_f = "Clic aqui para actualizar foto del deportista.";
	

			//}
//$fila = $resultado->fetch_assoc();
//$result=mysqli_query($mysqli,$sql);
  //$resul = $sqlAsp->fetch_assoc();
 
  ?>
<tbody  style="font-size:14px">
    <tr <?=$color?>  >

      <td><?php echo $fila['nombres']; ?></td>

      <td></td>

      <td><?php echo  $fila['apellidos']; ?></td>

      <td></td>

      <td><?php 
	  
	  
	  echo $fila['grado']; ?></td>

      <td></td>

      <td><?php echo  (int)$fila['cod_int']; ?></td>

      <td></td>

      <td align="center">
      <div class="container" style="display:flex">
      <div><a href="<?= $Href_g ?>" title="<?= $Comenta_g ?>"><img src="<?= $ImgEdit_g ?>" alt="" width="40" height="40" border="0" /></a></div>
      <div><a href="<?= $Href ?>" title="<?= $Comenta ?>"><img src="<?= $ImgEdit ?>" alt="" width="40" height="40" border="0" /></a></div>
    <div><a href="<?= $Href_f ?>" title="<?= $Comenta_f ?>"><img src="<?= $ImgEdit_f ?>" alt="" width="40" height="40" border="0" /></a></div>  
      
      
      </div>
      
      
      </td>

    </tr>

    <?php 

  

		}

  

  ?>

    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->

    <tr class="headerLista">
 <td>Total Atletas:<?php echo $CantAth; ?></td>

      <td></td>

      <td></td>

      <td></td>

      <td>&nbsp;</td>

      <td></td>

      <td>&nbsp;</td>

      <td></td>

      <td>&nbsp;</td>

    </tr>

   </tbody>
  </table>

  

  

<?php



	}else{

		

		echo "No presenta coincidencia";

	

	}

}

?>