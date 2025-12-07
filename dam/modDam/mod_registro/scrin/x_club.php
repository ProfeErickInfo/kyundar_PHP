<?php  
session_start();
$Xrefer = getenv('HTTP_REFERER');  
//if (!$ref || $ref != 'una_url.php')  
if (!$Xrefer) 
{  
    // Mostrar el error y redireccionar
	?>
     <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/salida.html" />
     <p>
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
?>
<button type="button"  class="btn btn-warning"  name="crear_sede" style="font-size:14px" id="crear_sede"  onClick="ocultar('DvOpciones2');cargarFocus('modDam/mod_registro/scrin/entidad.php','opciones','carga','txtNomclub');" ><img style="vertical-align:middle" class="avatar" src="../img/nuevo.png" width="30" height="30" >Crear Nuevo+</button>
<button type="button" class="btn btn-primary"  name="crear_sede" style="font-size:14px; alignment-adjust:middle" id="crear_sede"  onClick="mostrar('DvOpciones2');grupoFocus('modDam/mod_registro/scrin/head_lista_club.html','DvOpciones2','carga','','modDam/mod_registro/scrin/lista_club.php','opciones');" ><img style="vertical-align:middle" class="avatar" src="../img/lista2.png" width="30" height="30" >Mostrar Lista</button>

<div id="DvOpciones2" style="display:block; margin-top:20px"></div>

<div id="opciones" class="container" style=" width:100%;  height:500px; overflow:auto; display:block"></div>





<?php





}

?>