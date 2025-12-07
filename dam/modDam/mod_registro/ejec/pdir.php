<?php
//echo"verifica 1";
//session_start();
//include("../../../../enlace/conexion.php");

//	if (!$conexion) {

//		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

//	}
$sql = "SELECT MAX(id) AS nDir, nombre FROM tbx_club";
  $result = mysqli_query($conexion, $sql);
  $row = mysqli_fetch_object($result) ;
  $nDir=$row->nDir;
  //***********************************************
  $sql2 = "SELECT nombre FROM tbx_club where id=".$nDir;
  $result2 = mysqli_query($conexion, $sql2);
  $row2 = mysqli_fetch_object($result2) ;
  $nClub=$row2->nombre;
  //***********************************************
 
$rutaFilm="dam/sub_img/uploads";
$Ruta = $_SERVER['DOCUMENT_ROOT']."/".$rutaFilm."/".$nDir;
if(!file_exists($Ruta))
{
mkdir ($Ruta, 0777);
echo "Se ha creado el directorio: " . $nClub;
} else {
echo "El directorio: " . $nClub . " ya existe ";
}
?>