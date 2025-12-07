<?PHP 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Pragma: no-cache');
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];
ob_end_clean();

//echo "*".$id_usu;
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



	$opbusca = $_GET['opbusca'];
	$OrderBy = $_GET['oby']=='' ? 'nombres, apellidos' : $_GET['oby'];
    $vBusca = $_GET['vbusca'];
    $actual= 2021;
    $abierto=2021;
		
		
	

		

		

	$Query = "select a.id, a.nombres, a.apellidos, a.film, a.cod_int, (select g.nombre from tbx_grados g where g.id=a.id_grado) AS grado, a.documento from tbx_deportistas  a  where  a.id_Club=".$id_usu." order by a.nombres ASC ";
	
	
	

	
     $sqlAth = mysqli_query($conexion, $Query);
	
	$CantAth = mysqli_num_rows($sqlAth);

	

	if($CantAth!=0){

		

?>
<style>
.estilo-x { 
    
    font-size:1vw;
    
     }
</style>



 
 



    <!--INICIO VISUALIZACION RESULTADO DE LA CONSULTA -->

    <?php 

  

  		$c=1;

		//echo"ID_CLub".$id_usu;
 while ($fila=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC)){
					
clearstatcache();
				
			
if (file_exists("sub_img/uploads/".$id_usu."/".$fila['film'])||$fila['film']!='0.png') {
    $ImgEdit = "sub_img/uploads/".$id_usu."/".$fila['film'];
} else {
    $ImgEdit = "sub_img/uploads/0.png";
}
		//	echo $ImgEdit;

				
				$Href = "JavaScript:cargarFocus('modDam/mod_registro/scrin/facturApp.php?idAsoc=".$fila['id']."&idUsuario=".$id_usu."','DivContenido','carga','');";

				$Comenta = "Clic aqui para acceder a la informaci&oacute;n del deportista.";

			

			//}
//$fila = $resultado->fetch_assoc();
//$result=mysqli_query($mysqli,$sql);
  //$resul = $sqlAsp->fetch_assoc();
 
  ?>
<ol class="list-group ">

  <li class="list-group-item d-flex justify-content-between align-items-start">
  <img src="<?php echo $ImgEdit; ?>" width="20%" height="30%" class="img-fluid rounded-start" alt="...">
    <div class="ms-2 me-auto">
      <div class="fw-bold"><?php echo ucwords(strtolower($fila['nombres'])); ?></div>
      <small ><?php echo ucwords(strtolower($fila['apellidos'])); ?></small>
    </div>
   
  </li>
</ol>









   

    <?php 

  

		}

  

  ?>

    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->
 
 

    
       
  

 

<?php



	}else{

		

		?>
		<div class="row">

     <div class="col-12" align="left">
 <b class="estilo-x" style="color:#333">No existen Coincidencias</b>
    </div>

    
</div>

	<?


	

	}

}

?>
