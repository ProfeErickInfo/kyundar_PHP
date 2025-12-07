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


    $Query = "select a.id, a.nombres, a.apellidos, a.cod_int, a.fecha_nac, a.documento, a.film, a.sexo from tbx_deportistas a where  a.id_Club=".$id_usu." and concat(nombres,' ',apellidos) like '%".$vBusca."%'";
	//$Query = "select a.id, a.nombres, a.apellidos, a.film, a.cod_int, (select g.nombre from tbx_grados g where g.id=a.id_grado) AS grado, a.documento from tbx_deportistas  a  where  a.id_Club=".$id_usu." order by a.fecha_edit DESC ";
	
	
	

	
     $sqlAth = mysqli_query($conexion, $Query);
	
	$CantAth = mysqli_num_rows($sqlAth);

	?>
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

            
    $Href = "JavaScript:cargarFocus('modDam/mod_registro/scrin/facturApp.php?idAsoc=".$fila['id']."&idUsuario=".$id_usu."','DivContenido','carga','');";

    $Comenta = "Clic aqui para acceder a la informaci&oacute;n del deportista.";

        

        //}
//$fila = $resultado->fetch_assoc();
//$result=mysqli_query($mysqli,$sql);
//$resul = $sqlAsp->fetch_assoc();

?>

<li  class="list-group-item d-flex justify-content-between align-items-center">
<b class="estilo-x"><?php echo $fila['nombres']." ".$fila['apellidos']; ?></b>
<span class="badge badge-light " onclick="<?= $Href ?>" data-bs-toggle="modal" data-bs-target="#modal-f" >
  <img src="<?php echo $ImgEdit; ?>" alt="" width="80" height="90"  />

</span>
</li>


<?php 



    }



?>

<!--FINAL VISUALIZACION RESULTADO DE LA CONSULTA -->

</ul>
<?
}