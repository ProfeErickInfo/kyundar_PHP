<?php

@session_start();

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
$tipo=$_GET['tipo'];

if($tipo==2){
$sqlBarrio=mysqli_query($conexion,"select * from tbx_lista_barrios order by nombre");
}else{
	$sqlBarrio=mysqli_query($conexion,"select * from tbx_municipios where departamento_id=4 order by nombre");
}
?>
 <select name="Barrio" id="Barrio" class="form-control"   onKeyPress="return focusNext(this.form,'txtDireccion',event);">

                    <?php 						

					 while ($reg=mysqli_fetch_array($sqlBarrio)){

					

					echo "<option value=".$reg['id'].">".utf8_decode($reg['nombre'])."</option>";

				}

					?>

                  </select>
                  <?
}
				  
				  
				  ?>