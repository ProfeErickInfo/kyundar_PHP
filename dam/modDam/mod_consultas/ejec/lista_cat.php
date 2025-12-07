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
	$idGen = $_GET['idGen'];

	

	$sqlCat=mysqli_query($conexion,"select * from tbx_categoria where gen=".$idGen);
	

?>
Categoria: 
  <select name="Ncat" onchange="cargarFocus('nucleo/consultas/ejec/lista_peso.php?idCat='+this.value,'DvPeso','carga','');" id="Ncat" class="inputTxt" onkeypress="return focusNext(this.form,'',event);">
  <option value="0">Selecciona una</option>
  <?php 						

					 while ($reg=mysqli_fetch_array($sqlCat, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".utf8_encode($reg[1])."</option>";

				}

					?>
</select>
<?php

}
?>