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

	
	include("../../../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}


//connexion 



//connexion 




	

//séleccion de la base de datos




// obtenemos los datos del formulario.


$idReg=$_GET['idReg'];
$idDep=$_GET['idDep'];
//CONSULTO EL AÑO ABIERTO

	
$SqlDelPeso = mysqli_query($conexion, "DELETE from tbx_infoxpeso where id=".$idReg);
			
			
			
			
				//$SqlExiste = mysqli_query($conexion,"select Max(id) as Xid from tbx_infoxpeso ");

	

	//$CantAsp = mysql_num_rows($SqlExiste);
//$CantDep=$SqlExiste->num_rows;


	if($SqlDelPeso==0)

	{

		echo "No pudo eliminarse el peso del  deportista, intentelo nuevamente y si el problema persiste comuniquese con el administrador del sistema.";

	

	}else

		{  

			

		//	echo "Se Elimino el peso del deportista Satisfactoriamente.";
			?>
		
		<input type="button"  class="btn btn-success" value="Hecho - Recargar Lista" onClick="cargarFocus('modDam/mod_registro/scrin/peso.php?idDep=<?=$idDep?>','modal1dv','carga','');"/>
		
		
		<?
			
			

		
	
		}

	
}
?>