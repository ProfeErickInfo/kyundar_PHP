<?php
session_start(); 
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
include("../../enlace/conexion.php");

	if (!$conexion) {

		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";

		//exit;

	}

$id_usu=(int)@$_SESSION['id_usuario'];
$docu=$_GET['idDep'];
$sqlDep = mysqli_query($conexion,"select id, nombres, film, apellidos, tipo_doc, documento, fecha_nac, lugar_nac, sexo, barrio, direccion, nombreEps, celular, email, servsalud, cod_int  from tbx_deportistas a where id=".$docu);
$resultados=mysqli_fetch_array($sqlDep, MYSQLI_ASSOC);

 @$pic=$resultados["film"];


?>
<img src='sub_img/uploads/<?=$id_usu?>/<?=$pic?>'  width="40" height="50" style="alignment-adjust:auto">

