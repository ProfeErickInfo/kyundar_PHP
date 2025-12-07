<?PHP
session_start();
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
  if (isset($_POST['btnSend'])) {
$idClub=$_GET['idClub'];
$valmes=$_POST['valmes'];
$valclase=$_POST['valclase'];
$maximo=$_POST['maximo'];
$valextra=$_POST['valextra'];
echo "valmes= ".$valmes.", valclase= ".$valclase.", maxdias= ".$maximo.", valmas= ".$valextra;
  }else{
echo"NO NO NO";

  }
 $sqlBuscar = mysqli_query($conexion,"select id from tcx_config where id_club=".$idClub);
 $sqlSi=mysqli_num_rows($sqlBuscar);
 if ($sqlSi!=0){
   $editar ="UPDATE tcx_config SET  valmes=".$valmes.", valclase=".$valclase.", maxdias=".$maximo.", valmas=".$valextra." where id_club=".$idClub;
 // echo "UPDATE tcx_config SET  valmes=".$valmes.", valclase=".$valclase.", maxdias=".$maximo.", valmas=".$valextra." where id=".$idClub;
   mysqli_query($conexion,$editar);
   echo "Datos Actualizados Satisfactoriamente";
 }else{
echo "Datos NO Actualizados";
 $CantInfo=0;

 }
 
 
}
?>