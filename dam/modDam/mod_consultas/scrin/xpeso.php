<?php
include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	} 
	$xcat = $_GET['xcat'];
	
	$sqlPes=mysqli_query($conexion, "select * from tbx_pesos where id_cat=".$xcat);
	//echo "select * from tbx_pesos where id_cat=".$xcat;
?>
<select name="peso" id="peso"  class="TxtNew" onChange="cargarFocus('nucleo/consultas/ejec/BtnPdf1.php?cat='+categoria.value+'&pes='+peso.value+'&niv='+nivel.value+'&orden1='+orden1.value,'dvPdf1','carga','');" >
		
          <?php
		        echo "<option value='0'>Todos Los Pesos</option>";
				while ($reg2=mysqli_fetch_array($sqlPes, MYSQLI_NUM)){

					

					echo "<option value=".$reg2[0].">".$reg2[2]."</option>";

				}
			?>
        </select>