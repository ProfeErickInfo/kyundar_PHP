<?php
include("../../../../enlace/conexion.php");
	if (!$conexion) {
		echo "La conexion no se pudo realizar, consulte con su administrador del sistema.";
		//exit;
	}
$idE=$_GET['idE'];
//echo "est".$idE;
 $sqlvacio = mysql_query("select count(id) from tbx_deportistas " ,$conexion);
 $sqlsivacio=mysql_result($sqlvacio,0,0);
 if ($sqlsivacio!=0){
 $sqlInfo = mysql_query("select * from tbx_deportistas where id=".$idE,$conexion);
 $CantInfo = mysql_num_rows($sqlInfo);
  $logo=mysql_result($sqlInfo , 0 , "film");
 }else{
 $CantInfo=0;
 }
?>
<p><img src="pics/<?=$logo?>"  id="FotoPerfil" style="width:150px; height:200px"/>
</p>
<p>&nbsp;</p>
