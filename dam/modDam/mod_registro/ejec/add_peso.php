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



	$peso = $_GET['txtPeso'];
//	$grado = $_GET['grado'];
	$fecha = $_GET['txtFechaNac'];
	$idusu=$id_usu;
    $idDep=$_GET['idDep'];
//CONSULTO EL AÑO ABIERTO

	//echo "INSERT INTO tbx_infoxpeso(id_deportista, info, fecha) VALUES(".$idDep.", ".$peso." , '".$fecha."' )";
$SqlInsertPeso = mysqli_query($conexion, "INSERT INTO tbx_infoxpeso(id_deportista, info, fecha) VALUES(".$idDep.", ".$peso." , '".$fecha."' )");
			
			
			
			
				$SqlExiste = mysqli_query($conexion,"select Max(id) as Xid from tbx_infoxpeso ");

	

	//$CantAsp = mysql_num_rows($SqlExiste);
$CantDep=$SqlExiste->num_rows;


	if($CantDep==0)

	{

		echo "No pudo registrarse el peso del  deportista, intentelo nuevamente y si el problema persiste comuniquese con el administrador del sistema.";

	

	}else

		{  

			

		//	echo "Se Actualizo el peso del deportista Satisfactoriamente.";
			?>
		
		<input type="button"  class="btn btn-success" value="Hecho - Recargar Lista" onclick="cargarFocus('modDam/mod_registro/scrin/peso.php?idDep=<?=$idDep?>','modal1dv','carga','');"/>
		
		
		<?
			
			

		
	
		}

	
}
?>