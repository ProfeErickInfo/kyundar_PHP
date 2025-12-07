<?PHP 
session_start();
$id_usu=(int)@$_SESSION['id_usuario'];


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

	include("../../enlace/conexion.php"); 
	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}



	$opbusca = $_GET['opbusca'];
	$OrderBy = $_GET['oby']=='' ? 'nombres, apellidos' : $_GET['oby'];
    $vBusca = $_GET['vbusca'];
    $actual= 2021;
    $abierto=2021;
		
		
    $periodo=date("Y");
    $NmesA=(int)date("m");

		
    $Query = "select f.id_socio,  (select a1.nombres from tbx_deportistas as a1 where f.id_socio=a1.id) as nombres,(select a2.apellidos from tbx_deportistas as a2 where f.id_socio=a2.id) as apellidos,(select a3.film from tbx_deportistas as a3 where f.id_socio=a3.id) as film from tbx_reg_pago f where f.periodo=".$periodo." and f.mes=".$NmesA." and f.id_club=".$id_usu;
    $listaPagos = mysqli_query($conexion, $Query);
    $ClistP = mysqli_num_rows($listaPagos);
    if($ClistP!=0){
    
    
   

		

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
 while ($fila=mysqli_fetch_array($listaPagos, MYSQLI_ASSOC)){
					
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
