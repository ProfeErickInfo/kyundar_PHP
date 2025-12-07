<?php  
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
//echo  "usuario: ".$id_usu;
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



	$grado = $_GET['grado'];
	$fecha = $_GET['fecha'];
	$idusu=$id_usu;
    $idDep=$_GET['idDep'];
	//echo "grado:".$grado."-"."Fecha:".$fecha."-"."Usuario:".$idusu."-"."deportista:".$idDep;
//CONSULTO EL AÑO ABIERTO

	
$SqlInsertGrado = mysqli_query($conexion, "INSERT INTO tbx_infoxgrado(id_deportista, id_info, fecha, ultimo) VALUES(".$idDep.", ".$grado." , '".$fecha."',".$idusu." )");
/////////////////////////////////////////////////////////
$buscarMax=mysqli_query($conexion,"select MAX(id) AS mayor from tbx_infoxgrado where id_deportista=".$idDep);
$fila=mysqli_fetch_array($buscarMax, MYSQLI_ASSOC);

 $editar =mysqli_query($conexion,"UPDATE tbx_infoxgrado SET  ultimo=0 where id_deportista=".$idDep." and id<>".$fila['mayor']);
 
  $editar2 =mysqli_query($conexion,"UPDATE tbx_deportistas SET  id_grado=".$grado." where id=".$idDep);
   
 		
//////////////////////////////////////////////////////////			
			
			
				if($SqlInsertGrado==0)

	{

		echo "No pudo registrarse el grado del  deportista, intentelo nuevamente y si el problema persiste comuniquese con el administrador del sistema.";

	

	}else

		{  

			

			//echo "Se Actualizo el grado del deportista Satisfactoriamente.";
			?>
		
		<input type="button"  class="btn btn-success" value="Hecho - Recargar Lista" onClick="cargarFocus('modDam/mod_registro/scrin/grados.php?idDep=<?=$idDep?>','modal1dv','carga','');"/> 
		
		
		<?
			
			

		
	
		}

	
}
?>