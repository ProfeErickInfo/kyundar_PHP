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
<button type="button"  class="btnclass"  name="crear_sede" style="font-size:14px" id="crear_sede"  onClick="ocultar('DvOpciones2');cargarFocus('modDam/mod_consultas/scrin/consulta_gen.php','opciones','carga','');" ><img style="vertical-align:middle" class="avatar" src="../img/busca_dep.png" width="30" height="30" >Buscar Por Deportistas</button>

<button type="button" class="btnclass2"  name="crear_sede" style="font-size:14px;" id="crear_sede"  onClick="ocultar('DvOpciones2');cargarFocus('modDam/mod_consultas/scrin/consulta_club.php','opciones','carga','');"><img style="vertical-align:middle" class="avatar" src="../img/buscaClub.png" width="40" height="30" > Buscar Por Clubes</button>

<div id="DvOpciones2" style="display:block; margin-top:20px"></div>

<div id="opciones" style=" width:100%;  height:500px; overflow:auto; display:block"></div>



<?php





}

?>