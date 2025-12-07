<?PHP 
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
$idEvent=$_SESSION['idEvent'];
$Xrefer = getenv('HTTP_REFERER');  
if ((!$Xrefer) || ($id_usu==0)){
	?>
     <meta http-equiv="Refresh" content="0; URL=<?Php $_SERVER ['SERVER_NAME']; ?>/sesionOut.html" />
     <?php
		exit();
	}else{
    // Se ejecuta el ajax normalmente  
 
?>  
<?php 

	include("../../../../enlace/conexion.php");


	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}



$id_usu=(int)@$_SESSION['id_usuario'];
$idDep = $_GET['idAtleta'];

	//$cod=$_GET['codE'];

$SqlExisteC = mysqli_query($conexion,"select id from tbx_deportistas where id=".$idDep);
@$CantC =(int)mysqli_num_rows($SqlExisteC);
	


////////////////////////////////////////////////
if($CantC!=0){
	$sqlV=mysqli_query($conexion,"select * from trn_regdep_evento  where id_dep=".$idDep." and id_evento=".$idEvent);
    $CantV = mysqli_num_rows($sqlV);

		if($CantV==0){
 			$SqlUpdateAt = mysqli_query($conexion,"update tbx_deportistas set id_Club=0 where id=".$idDep);
	    	}else{	
			echo "El atleta aparece registrado en el evento activo. ";
		
		}

}else{	
    echo "El atleta ya no esta registrado a la entidad.";
		
	}
	
 if($SqlUpdateAt!=0){
    $Hrefx ="JavaScript:cargarFocus('modDam/mod_registro/scrin/Rdep.php','DivContenido','carga','');";
      
	   ?>
	    
		<div class="col-auto"  style="align-content: end;">
		 Realizada la de baja.
	  			 <a style=" cursor:pointer; color: red; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight:bolder" href="<?= $Hrefx ?>">Cerrar</a>
	   </div>
	   <?php
      }else{	
			
            ?>
		 <div class="col-auto"  style="align-content: end;">	
		 Imposible dar de baja.
	  			 <a style=" cursor:pointer; color: red; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight:bolder" href="<?= $Hrefx ?>">Cerrar</a>
	   </div>
	   <?php 
	}	

}
?>
