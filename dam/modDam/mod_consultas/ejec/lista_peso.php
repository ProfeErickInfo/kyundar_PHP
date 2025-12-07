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
	$idCat = $_GET['idCat'];

	$sqlPeso=mysqli_query($conexion,"select * from tbx_pesos where id_cat=".$idCat);

		

?>
Peso Kg: 
<select name="xPeso" id="xPeso" class="inputTxt" onkeypress="return focusNext(this.form,'',event);">
  <?php 						

					 while ($reg=mysqli_fetch_array($sqlPeso, MYSQLI_NUM)){

					

					echo "<option value=".$reg[0].">".utf8_encode($reg[2])."</option>";

				}

					?>
</select>


<?php

}
?>