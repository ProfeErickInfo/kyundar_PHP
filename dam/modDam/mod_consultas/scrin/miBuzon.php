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
.estilo-x { font-size: calc(1em + 1vw) }
</style>
<div style="color:#333">

<ul class="list-group">
 
 



    <!--INICIO VISUALIZACION RESULTADO DE LA CONSULTA -->

    <?php 

  

  		$c=1;

		//echo"ID_CLub".$id_usu;
 while ($fila=mysqli_fetch_array($sqlAth, MYSQLI_ASSOC)){
					//echo "".$fila['nombres']."-".$fila['apellidos']."";
clearstatcache();
				//}
  		//for($i=0;$i<$CantAth;$i++){
//echo "sub_img/uploads/".$id_usu."/".$fila['film'];
			
if (file_exists("sub_img/uploads/".$id_usu."/".$fila['film'])||$fila['film']!='0.png') {
    $ImgEdit = "sub_img/uploads/".$id_usu."/".$fila['film'];
} else {
    $ImgEdit = "sub_img/uploads/0.png";
}
		//	echo $ImgEdit;

				
				$Href = "JavaScript:cargarFocus('modDam/mod_registro/scrin/editApp.php?docuAsp=".$fila['id']."','DivContenido','carga','');";

				$Comenta = "Clic aqui para acceder a la informaci&oacute;n del deportista.";

			

			//}
//$fila = $resultado->fetch_assoc();
//$result=mysqli_query($mysqli,$sql);
  //$resul = $sqlAsp->fetch_assoc();
 
  ?>
  
   <li  class="list-group-item d-flex justify-content-between align-items-center">
   <b class="estilo-x"><?php echo $fila['nombres']." ".$fila['apellidos']; ?></b>
   
  </li>


    <?php 

  

		}

  

  ?>

    <!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->
 
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <b class="estilo-x"}>Total Atletas:</b>
    <span class="badge badge-primary badge-pill" style="font-size:large"><?php echo $CantAth; ?></span>
  </li>
</ul>
    
 <div class="form-footer">
            <!-- form footer, let say for submit button -->
            <p>&nbsp;</p>
            <p>&nbsp;</p>
         </div>         
  
</div>
  <div class="row">

     <div class="col-12" align="right">   
              
    <button class="btn btn-info" type="button" name="btnRegistrar2" value="Actualizar" id="btnRegistrar2"  onclick="javascript:location.reload()" >Regresar</button>

</div>
</div>

<?php



	}else{

		

		echo "No presenta coincidencia";

	

	}

}

?>
